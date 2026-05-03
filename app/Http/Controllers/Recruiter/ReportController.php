<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company->id;

        // 1. Thống kê tổng quan
        $stats = [
            'total_jobs' => JobPost::where('company_id', $companyId)->count(),
            'active_jobs' => JobPost::where('company_id', $companyId)->where('status', 'open')->count(),
            'total_applicants' => Application::whereHas('jobPost', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })->count(),
            'high_match_count' => Application::whereHas('jobPost', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })->where('match_score', '>=', 80)->count(),
        ];

        // 2. Dữ liệu biểu đồ: Số lượng ứng viên theo trạng thái
        $statusDistribution = Application::whereHas('jobPost', function ($q) use ($companyId) {
            $q->where('company_id', $companyId);
        })
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 3. Top các công việc có nhiều người nộp nhất
        $topJobs = JobPost::where('company_id', $companyId)
            ->withCount('applications')
            ->orderBy('applications_count', 'desc')
            ->take(5)
            ->get();

        return view('recruiter.reports.index', compact('stats', 'statusDistribution', 'topJobs'));
    }
}