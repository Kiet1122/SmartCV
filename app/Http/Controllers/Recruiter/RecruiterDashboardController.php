<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\Company;
use Carbon\Carbon;
use DB;


class RecruiterDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            return redirect()->route('recruiter.company.setup')->with('error', 'Vui lòng cập nhật thông tin công ty.');
        }

        $companyId = $company->id;
        $jobPostIds = JobPost::where('company_id', $companyId)->pluck('id');

        // 1. Thống kê số liệu chi tiết
        $stats = [
            'active_jobs' => JobPost::where('company_id', $companyId)->where('status', 'open')->count(),
            'total_applicants' => Application::whereIn('job_post_id', $jobPostIds)->count(),
            'ai_screened' => Application::whereIn('job_post_id', $jobPostIds)->whereNotNull('match_score')->count(),
            'pending_review' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'applied')->count(),
            'shortlisted' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'interviewing')->count(),
            'rejected' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'rejected')->count(),
            'hired' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'hired')->count(),
        ];

        // 2. Điểm AI trung bình (trên thang 100 của bạn)
        $avgAIScore = Application::whereIn('job_post_id', $jobPostIds)
            ->whereNotNull('match_score')
            ->avg('match_score') ?? 0;

        // 3. Tăng trưởng ứng viên (So với tháng trước)
        $currentMonth = Application::whereIn('job_post_id', $jobPostIds)->whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonth = Application::whereIn('job_post_id', $jobPostIds)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $stats['applicant_growth'] = $lastMonth > 0 ? round(($currentMonth - $lastMonth) / $lastMonth * 100) : ($currentMonth > 0 ? 100 : 0);

        // 4. Dữ liệu biểu đồ (7 ngày gần nhất)
        $chartData = $this->getApplicantChartData($jobPostIds);

        // 5. Danh sách Job đang hoạt động để hiển thị bảng
        $activeJobList = JobPost::where('company_id', $companyId)
            ->whereIn('status', ['open', 'pending'])
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 6. Ứng viên mới nhất
        $recentApplications = Application::whereIn('job_post_id', $jobPostIds)
            ->with(['candidate.user', 'jobPost'])
            ->latest()
            ->take(5)
            ->get();

        return view('recruiter.dashboard', compact(
            'company',
            'stats',
            'chartData',
            'activeJobList',
            'recentApplications',
            'avgAIScore'
        ));
    }

    private function getApplicantChartData($jobPostIds)
    {
        $data = [];
        $startOfWeek = Carbon::now()->startOfWeek();
        $maxCount = Application::whereIn('job_post_id', $jobPostIds)
            ->where('created_at', '>=', $startOfWeek)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('count(*) as count'))
            ->get()->max('count') ?? 1;

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $count = Application::whereIn('job_post_id', $jobPostIds)->whereDate('created_at', $date)->count();
            $data[] = [
                'day' => $date->format('D'),
                'count' => $count,
                'height' => $count > 0 ? ($count / $maxCount) * 100 : 5
            ];
        }
        return $data;
    }
}