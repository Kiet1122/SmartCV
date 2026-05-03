<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $applicant = Application::with([
            'candidate.user',
            'jobPost',
            'aiMatching'
        ])->findOrFail($id);

        return view('recruiter.applicants.show', compact('applicant'));
    }
}