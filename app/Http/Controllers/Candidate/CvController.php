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

        // Giới hạn số lượng CV
        if ($user->cvs()->count() >= 5) {
            return back()->withErrors(['cv_file' => 'Bạn chỉ được tải lên tối đa 5 CV. Vui lòng xóa bớt CV cũ.']);
        }

        // 1. Lưu file vật lý
        $file = $request->file('cv_file');

        // 👉 Lấy tên file gốc (Bỏ đuôi .pdf) để làm tên hiển thị
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('cvs', $fileName, 'public');

        $isFirstCv = $user->cvs()->count() === 0;

        // 2. Lưu vào Database CÓ KÈM TÊN CV (cv_name)
        $cv = $user->cvs()->create([
            'cv_name' => $originalName,
            'file_url' => $filePath,
            'is_default' => $isFirstCv,
        ]);

        // =====================================================================
        // 3. GỌI MICROSERVICE PYTHON AI ĐỂ ĐỌC CV VÀ LƯU JSON
        // =====================================================================
        try {
            $absolutePath = storage_path('app/public/' . $filePath);

            $response = Http::timeout(60)->attach(
                'file',
                fopen($absolutePath, 'r'),
                $fileName
            )->post('http://127.0.0.1:8080/api/parse-cv');

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['status']) && $responseData['status'] === 'success') {
                    $cv->update([
                        'raw_text' => $responseData['raw_text'],
                        'parsed_data' => $responseData['parsed_data'],
                        'experience_years' => $responseData['parsed_data']['experience_years'] ?? 0
                    ]);
                } else {
                    Log::error('AI Parser Logic Error: ' . ($responseData['message'] ?? 'Unknown error'));
                }
            } else {
                Log::error('AI Parser HTTP Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Cannot connect to AI Microservice: ' . $e->getMessage());
        }

        return back()->with('success', 'Tải CV lên thành công! Hồ sơ đã được AI phân tích.');
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

    /**
     * Hiển thị trang Review dữ liệu AI đã trích xuất
     */
    public function reviewParsedData($id)
    {
        $cv = Auth::user()->cvs()->findOrFail($id);

        if (!$cv->parsed_data) {
            return redirect()->route('candidate.cv.index')->withErrors(['cv_file' => 'CV này chưa được AI xử lý.']);
        }

        return view('candidate.cv.review_parsed_data', compact('cv'));
    }

    /**
     * Lưu lại dữ liệu AI do người dùng chỉnh sửa
     */
    public function updateParsedData(Request $request, $id)
    {
        $cv = Auth::user()->cvs()->findOrFail($id);
        $data = $request->all();

        // Lấy cục JSON cũ ra để đè dữ liệu mới lên
        $parsedData = $cv->parsed_data;

        // 1. Cập nhật các trường đơn giản
        $parsedData['personal_info'] = $data['personal_info'] ?? $parsedData['personal_info'];
        $parsedData['summary'] = $data['summary'] ?? '';
        $parsedData['experience_years'] = floatval($data['experience_years'] ?? 0);

        // 2. Chuyển các chuỗi cách nhau bằng dấu phẩy thành mảng (Array)
        $parsedData['skills'] = array_filter(array_map('trim', explode(',', $data['skills'] ?? '')));
        $parsedData['languages'] = array_filter(array_map('trim', explode(',', $data['languages'] ?? '')));
        $parsedData['certifications'] = array_filter(array_map('trim', explode(',', $data['certifications'] ?? '')));
        $parsedData['achievements'] = array_filter(array_map('trim', explode(',', $data['achievements'] ?? '')));

        // 3. Cập nhật mảng Object (Kinh nghiệm, Dự án)
        $parsedData['work_experience'] = $data['work_experience'] ?? [];

        // Riêng mảng Projects, phải ép cái mảng technologies dạng string về lại Array
        if (isset($data['projects'])) {
            foreach ($data['projects'] as $index => $proj) {
                if (is_string($proj['technologies'])) {
                    $data['projects'][$index]['technologies'] = array_filter(array_map('trim', explode(',', $proj['technologies'])));
                }
            }
            $parsedData['projects'] = $data['projects'];
        }

        // Lưu lại vào DB
        $cv->update([
            'parsed_data' => $parsedData,
            'experience_years' => $parsedData['experience_years'] // Cập nhật luôn cột cache
        ]);

        // CẢNH BÁO: Vì nội dung Text đã thay đổi, lý tưởng nhất là chỗ này 
        // bạn nên gọi lại API Python (/api/embed) để cập nhật lại Vector nhúng (Embedding)
        // Nhưng tạm thời cứ lưu JSON trước đã.

        return redirect()->route('candidate.cv.index')->with('success', 'Dữ liệu CV đã được cập nhật thành công!');
    }

    public function show($id)
    {
        $cv = Auth::user()->cvs()->findOrFail($id);
        return view('candidate.cv.show', compact('cv'));
    }

    /**
     * Xuất CV ra file PDF mẫu chuẩn
     */
    public function downloadPdf($id)
    {
        $cv = Auth::user()->cvs()->findOrFail($id);

        if (!$cv->parsed_data) {
            return back()->withErrors(['cv_file' => 'CV chưa được phân tích, không thể xuất PDF.']);
        }
        // Đổi từ $user->profile thành $user->candidateProfile
        $profile = $cv->user->candidateProfile;

        $pdf = Pdf::loadView('candidate.cv.pdf_template', compact('cv', 'profile'));

        // Tạo tên file đẹp: VD: SmartCV_Cao_Nien_Truong_Son.pdf
        $candidateName = $cv->parsed_data['personal_info']['name'] ?? 'CV';
        $fileName = 'SmartCV_' . Str::slug($candidateName) . '.pdf';

        return $pdf->download($fileName);
    }

    public function generateAndSaveCv(Request $request)
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        // 1. Thu thập dữ liệu từ Form Tạo CV (Giả sử form gửi lên cấu trúc giống hệt parsed_data)
        // Lưu ý: Tùy vào form HTML của bạn thiết kế, bạn có thể map lại mảng này cho đúng.
        $parsedData = $request->all();

        // Tính toán lại số năm kinh nghiệm nếu người dùng không nhập
        $experienceYears = floatval($parsedData['experience_years'] ?? 0);

        // 2. Dựng đối tượng CV "ảo" để truyền vào thư viện DomPDF
        $cvDummy = new CV();
        $cvDummy->parsed_data = $parsedData;
        $cvDummy->experience_years = $experienceYears;

        // 3. Render giao diện PDF
        // Chú ý: Đảm bảo view 'candidate.cv.pdf_template' của bạn đã có sẵn như ở các bước trước
        $pdf = Pdf::loadView('candidate.cv.pdf_template', [
            'cv' => $cvDummy,
            'profile' => $profile
        ]);

        // 4. Tạo tên file và lưu vật lý vào thư mục storage/app/public/cvs
        $candidateName = $parsedData['personal_info']['name'] ?? $user->name;
        $fileName = 'SmartCV_Builder_' . time() . '_' . Str::slug($candidateName) . '.pdf';
        $filePath = 'cvs/' . $fileName; // Thư mục lưu: storage/app/public/cvs/

        // Ghi file PDF vào ổ cứng
        Storage::disk('public')->put($filePath, $pdf->output());

        // 5. Import vào Database (Bảng cvs)
        $newCv = $user->cvs()->create([
            'cv_name' => 'CV Tạo Tự Động (' . date('d/m/Y') . ')',
            'file_url' => $filePath, // Link file vật lý vừa tạo
            'parsed_data' => $parsedData, // Data JSON để sau này AI Matching
            'experience_years' => $experienceYears,
            'is_default' => false,
            // 'embedding' => null // (Tùy chọn) Gọi API Python tạo vector nếu cần
        ]);

        // 6. Tự động trả về file PDF cho ứng viên tải xuống
        return $pdf->download($fileName);
    }
}