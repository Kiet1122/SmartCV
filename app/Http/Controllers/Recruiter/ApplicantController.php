<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicationResult;


class ApplicantController extends Controller
{
    // Hiển thị danh sách ứng viên theo từng tin tuyển dụng hoặc tất cả
    public function index()
    {
        $companyId = Auth::user()->company->id;
        // Lấy danh sách Job kèm số lượng ứng viên để hiển thị ở ngoài
        $jobs = JobPost::where('company_id', $companyId)
            ->withCount('applications')
            ->latest()
            ->get();

        return view('recruiter.applicants.index', compact('jobs'));
    }

    // Hàm bổ sung để lấy ứng viên của 1 Job cụ thể (AJAX hoặc Page mới)
    public function listByJob(JobPost $job)
    {
        $applications = $job->applications()
            ->with(['candidate.user', 'aiMatching'])
            ->orderByDesc('match_score')
            ->get();

        return view('recruiter.applicants.list_by_job', compact('job', 'applications'));
    }

    public function show($id)
    {
        // Load Application kèm theo Candidate, User, Job và đặc biệt là CV + Review
        $applicant = Application::with([
            'candidate.user',
            'jobPost', // Quan trọng: lấy đánh giá AI từ bảng cv_reviews qua quan hệ review
        ])->findOrFail($id);

        // Kiểm tra quyền sở hữu
        if ($applicant->jobPost->company_id !== Auth::user()->company->id) {
            abort(403);
        }

        return view('recruiter.applicants.show', compact('applicant'));
    }

    public function updateStatus(Request $request, $id)
    {
        $applicant = Application::with('candidate.user', 'jobPost')->findOrFail($id);

        // Bảo mật: Check quyền sở hữu job
        if ($applicant->jobPost->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $status = $request->status; // 'accepted' hoặc 'rejected'
        $applicant->update(['status' => $status]);

        // Gửi Email nếu được chấp nhận (hoặc từ chối tùy bạn muốn)
        try {
            Mail::to($applicant->candidate->user->email)->send(new ApplicationResult($applicant, $status));
        } catch (\Exception $e) {
            \Log::error("Lỗi gửi mail: " . $e->getMessage());
        }

        return back()->with('success', 'Đã cập nhật trạng thái và gửi thông báo cho ứng viên.');
    }

    public function downloadCv($id)
    {
        $applicant = Application::with('cv', 'candidate.user')->findOrFail($id);

        // Đường dẫn thực tế trong thư mục storage/app/public/
        $filePath = $applicant->cv->file_url;

        // Kiểm tra file có tồn tại trong disk public không
        if ($filePath && \Storage::disk('public')->exists($filePath)) {
            // Lấy đuôi file gốc (pdf, docx...)
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $fileName = \Str::slug($applicant->candidate->user->name) . '_CV.' . $extension;

            return \Storage::disk('public')->download($filePath, $fileName);
        }

        // Nếu không thấy file, Laravel sẽ redirect back kèm thông báo lỗi
        return back()->with('error', 'Không tìm thấy file CV trên hệ thống. Đường dẫn: ' . $filePath);
    }
}