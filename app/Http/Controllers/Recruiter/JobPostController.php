<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company->id;
        $jobs = JobPost::where('company_id', $companyId)->latest()->get();
        return view('recruiter.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $skills = Skill::all();
        return view('recruiter.jobs.form', compact('skills'));
    }

    public function edit(JobPost $job)
    {

        $skills = Skill::all();

        $selectedSkills = $job->skills->pluck('id')->toArray();

        return view('recruiter.jobs.form', compact('job', 'skills', 'selectedSkills'));

    }

    public function store(Request $request)
    {
        $this->validateJob($request);

        // 1. Tạo tin với trạng thái ban đầu là 'pending' (Đang kiểm duyệt)
        $job = JobPost::create([
            'company_id' => Auth::user()->company->id,
            'title' => $request->title,
            'description' => $request->description,
            'experience_required' => $request->experience_required,
            'status' => 'pending',
        ]);

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        // 2. Chạy kiểm duyệt AI
        $result = $this->runAICheck($job);

        return redirect()->route('recruiter.jobs.index')->with($result['type'], $result['msg']);
    }

    public function update(Request $request, JobPost $job)
    {
        $this->validateJob($request);

        // Khi cập nhật, đưa status về 'pending' ngay lập tức
        $job->update(array_merge($request->all(), ['status' => 'pending']));

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        // Chạy lại kiểm duyệt AI cho nội dung mới
        $result = $this->runAICheck($job);

        return redirect()->route('recruiter.jobs.index')->with($result['type'], $result['msg']);
    }

    /**
     * Logic chạy kiểm duyệt AI chuyên sâu
     */
    private function runAICheck(JobPost $job)
    {
        // Mặc định ban đầu
        $type = 'info';
        $msg = 'Tin đang trong quá trình kiểm duyệt bởi AI.';

        try {
            // Gọi Microservice Llama 3.1 (Port 8003)
            $response = Http::timeout(30)->post('http://127.0.0.1:8003/api/check-job', [
                'title' => $job->title,
                'description' => $job->description,
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if ($result['is_safe'] === true) {
                    // AI duyệt thành công -> Chuyển sang 'open' (Đang mở)
                    $job->update(['status' => 'open']);
                    $type = 'success';
                    $msg = 'Kiểm duyệt hoàn tất. Tin tuyển dụng hiện đang được hiển thị!';
                } else {
                    // AI từ chối -> Chuyển sang 'rejected' (Bị từ chối)
                    $job->update(['status' => 'rejected']);
                    $type = 'error';
                    $msg = 'Tin bị từ chối do vi phạm: ' . ($result['reason'] ?? 'Nội dung không hợp lệ');
                }
            } else {
                // Lỗi kỹ thuật từ phía Server AI
                $job->update(['status' => 'open']); // Tạm cho qua để tránh phiền người dùng
                $type = 'warning';
                $msg = 'AI đang bận, tin đã được hiển thị tạm thời.';
            }
        } catch (\Exception $e) {
            $job->update(['status' => 'open']);
            $type = 'warning';
            $msg = 'Hệ thống kiểm duyệt gặp sự cố, tin của bạn đã được đăng.';
            Log::error("Connection to Port 8003 failed: " . $e->getMessage());
        }

        return ['type' => $type, 'msg' => $msg];
    }

    private function validateJob(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'experience_required' => 'nullable|numeric',
            'skills' => 'array'
        ]);
    }

    public function destroy(JobPost $job)
    {
        $job->delete();
        return back()->with('success', 'Đã xóa tin tuyển dụng.');
    }

    public function close(JobPost $job)
    {
        // Kiểm tra quyền sở hữu (chỉ nhà tuyển dụng tạo ra tin mới được đóng)
        if ($job->company_id !== Auth::user()->company->id) {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $job->update(['status' => 'closed']);

        return back()->with('success', 'Tin tuyển dụng đã được đóng thành công.');
    }
}