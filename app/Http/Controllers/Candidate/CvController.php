<?php

namespace App\Http\Controllers\Candidate;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Cv;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use DB;

class CvController extends Controller
{
    /**
     * Hiển thị danh sách CV của Ứng viên
     */
    public function index()
    {
        $user = Auth::user();
        $cvs = $user->cvs()->orderBy('created_at', 'desc')->get();
        return view('candidate.cv.index', compact('cvs'));
    }

    /**
     * Xử lý tải file CV lên và gửi cho AI phân tích
     */
    public function store(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf|max:5120',
        ], [
            'cv_file.required' => 'Vui lòng chọn file CV.',
            'cv_file.mimes' => 'Hệ thống AI hiện tại chỉ hỗ trợ định dạng PDF.',
            'cv_file.max' => 'Dung lượng file không được vượt quá 5MB.',
        ]);

        $user = Auth::user();

        if ($user->cvs()->count() >= 5) {
            return back()->withErrors(['cv_file' => 'Bạn chỉ được tải lên tối đa 5 CV. Vui lòng xóa bớt CV cũ.']);
        }

        // 1. Lưu file vật lý
        $file = $request->file('cv_file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('cvs', $fileName, 'public');

        try {
            DB::beginTransaction(); // Bắt đầu giao dịch để đảm bảo an toàn dữ liệu

            $isFirstCv = $user->cvs()->count() === 0;

            // 2. Khởi tạo bản ghi CV
            $cv = $user->cvs()->create([
                'cv_name' => $originalName,
                'file_url' => $filePath,
                'is_default' => $isFirstCv,
            ]);

            // 3. GỌI MICROSERVICE PYTHON AI
            $absolutePath = storage_path('app/public/' . $filePath);
            $response = Http::timeout(60)->attach(
                'file',
                fopen($absolutePath, 'r'),
                $fileName
            )->post('http://127.0.0.1:8080/api/parse-cv');

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['status']) && $responseData['status'] === 'success') {
                    $parsed = $responseData['parsed_data'];

                    // Cập nhật thông tin chính vào bảng CVS
                    $cv->update([
                        'raw_text' => $responseData['raw_text'],
                        'parsed_data' => $parsed,
                        'experience_years' => $parsed['experience_years'] ?? 0
                    ]);

                    // 👉 4. LƯU KINH NGHIỆM LÀM VIỆC (Bảng experiences)
                    if (!empty($parsed['work_experience'])) {
                        foreach ($parsed['work_experience'] as $work) {
                            $cv->experiences()->create([
                                'company' => $work['company'] ?? 'N/A',
                                'position' => $work['job_title'] ?? 'N/A',
                                'start_date' => isset($work['start_year']) ? "{$work['start_year']}-" . ($work['start_month'] ?? '01') . "-01" : null,
                                'end_date' => ($work['is_current'] ?? false) ? null : (isset($work['end_year']) ? "{$work['end_year']}-" . ($work['end_month'] ?? '01') . "-01" : null),
                            ]);
                        }
                    }

                    // 👉 5. MAPPING SKILLS (Bảng cv_skill)
                    if (!empty($parsed['skills'])) {
                        // Lọc và lấy ID của các skill có sẵn trong database (do Admin quản lý)
                        $skillIds = \App\Models\Skill::whereIn('name', array_map('trim', $parsed['skills']))
                            ->pluck('id')
                            ->toArray();

                        if (!empty($skillIds)) {
                            $cv->skills()->sync($skillIds); // Dùng sync để tránh trùng lặp
                        }
                    }

                    // 👉 6. MAPPING LANGUAGES (Bảng cv_language)
                    if (!empty($parsed['languages'])) {
                        foreach ($parsed['languages'] as $langName) {
                            $language = \App\Models\Language::where('name', 'LIKE', trim($langName))->first();
                            if ($language) {
                                $cv->languages()->attach($language->id, ['proficiency' => $langName]);
                            }
                        }
                    }

                } else {
                    throw new \Exception('AI Parser Logic Error: ' . ($responseData['message'] ?? 'Unknown error'));
                }
            } else {
                throw new \Exception('AI Parser HTTP Error: ' . $response->body());
            }

            DB::commit(); // Hoàn tất lưu mọi thứ
            return back()->with('success', 'Tải CV lên thành công! Hồ sơ đã được AI phân tích chi tiết.');

        } catch (\Exception $e) {
            DB::rollBack(); // Nếu có lỗi, xóa sạch các bản ghi đã tạo trong DB
            Log::error('CV Processing Failed: ' . $e->getMessage());

            // (Tùy chọn) Xóa file vật lý nếu lưu DB thất bại
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->withErrors(['cv_file' => 'Có lỗi xảy ra khi xử lý AI: ' . $e->getMessage()]);
        }
    }

    /**
     * Cập nhật tên hiển thị của CV
     */
    public function updateName(Request $request, $id)
    {
        $request->validate([
            'cv_name' => 'required|string|max:255',
        ], [
            'cv_name.required' => 'Tên CV không được để trống.',
            'cv_name.max' => 'Tên CV quá dài.'
        ]);

        // Đảm bảo user chỉ đổi tên được CV của chính mình
        $cv = Auth::user()->cvs()->findOrFail($id);

        $cv->update([
            'cv_name' => $request->cv_name
        ]);

        return back()->with('success', 'Đã đổi tên CV thành công.');
    }

    /**
     * Đặt CV làm mặc định
     */
    public function setDefault($id)
    {
        $user = Auth::user();
        $user->cvs()->update(['is_default' => false]);
        $user->cvs()->where('id', $id)->update(['is_default' => true]);
        return back()->with('success', 'Đã thay đổi CV mặc định.');
    }

    /**
     * Xóa CV
     */
    public function destroy($id)
    {
        $cv = Auth::user()->cvs()->findOrFail($id);
        if (Storage::disk('public')->exists($cv->file_url)) {
            Storage::disk('public')->delete($cv->file_url);
        }
        $cv->delete();
        return back()->with('success', 'Đã xóa CV thành công.');
    }

    // /**
    //  * Hiển thị trang Review dữ liệu AI đã trích xuất
    //  */
    // public function reviewParsedData($id)
    // {
    //     $cv = Auth::user()->cvs()->findOrFail($id);

    //     if (!$cv->parsed_data) {
    //         return redirect()->route('candidate.cv.index')->withErrors(['cv_file' => 'CV này chưa được AI xử lý.']);
    //     }

    //     return view('candidate.cv.review_parsed_data', compact('cv'));
    // }


    public function show($id)
    {
        $cv = Auth::user()->cvs()->findOrFail($id);
        return view('candidate.cv.show', compact('cv'));
    }

}