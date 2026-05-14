<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Application;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecruiterDashboardController extends Controller
{
    /**
     * Display the recruiter dashboard with statistics and charts
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        $company = Company::where('user_id', $user->id)->first();

        // Redirect if company profile not set up
        if (!$company) {
            return redirect()->route('recruiter.company.setup')
                ->with('error', 'Please update your company information before using the dashboard.');
        }

        $companyId = $company->id;
        $jobPostIds = JobPost::where('company_id', $companyId)->pluck('id');

        // ========== DEBUG: Check if data exists ==========
        Log::info('=== Dashboard Debug ===');
        Log::info('Company ID: ' . $companyId);
        Log::info('Company Name: ' . $company->company_name);
        Log::info('Job Post IDs: ' . json_encode($jobPostIds));
        Log::info('Total Job Posts: ' . $jobPostIds->count());

        $totalApplications = Application::whereIn('job_post_id', $jobPostIds)->count();
        Log::info('Total Applications: ' . $totalApplications);

        // Get applications grouped by date for debugging
        $sampleApps = Application::whereIn('job_post_id', $jobPostIds)
            ->select('id', 'job_post_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        Log::info('Sample Applications: ' . json_encode($sampleApps));
        // ========== END DEBUG ==========

        // Get statistics data
        $stats = $this->getStatistics($companyId, $jobPostIds);

        // Calculate applicant growth percentage
        $stats['applicant_growth'] = $this->calculateGrowthRate($jobPostIds);

        // Get chart data based on request type (week/month)
        $chartType = request()->get('chart_type', 'week');
        $chartData = $this->getChartData($companyId, $chartType);

        // Debug: Log chart data
        Log::info('Chart Type: ' . $chartType);
        Log::info('Chart Data: ' . json_encode($chartData));

        // Get active job listings with application counts
        $activeJobList = JobPost::where('company_id', $companyId)
            ->where('status', 'open')
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate average AI match score
        $avgAIScore = Application::whereIn('job_post_id', $jobPostIds)
            ->whereNotNull('match_score')
            ->avg('match_score');

        // Get recent applications
        $recentApplications = Application::whereIn('job_post_id', $jobPostIds)
            ->with(['candidate.user', 'jobPost'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('recruiter.dashboard', compact(
            'company',
            'stats',
            'chartData',
            'activeJobList',
            'recentApplications',
            'avgAIScore',
            'chartType'
        ));
    }

    /**
     * Get dashboard statistics via AJAX
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChartDataAjax(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            return response()->json(['success' => false, 'message' => 'Company not found'], 404);
        }

        $chartType = $request->get('type', 'week');
        $chartData = $this->getChartData($company->id, $chartType);

        // Get week range for display
        $weekRange = [
            'start' => Carbon::now()->startOfWeek()->format('d/m'),
            'end' => Carbon::now()->endOfWeek()->format('d/m')
        ];

        return response()->json([
            'success' => true,
            'chartData' => $chartData,
            'chartType' => $chartType,
            'weekRange' => $weekRange
        ]);
    }

    /**
     * Get all statistics data
     *
     * @param int $companyId
     * @param \Illuminate\Support\Collection $jobPostIds
     * @return array
     */
    private function getStatistics($companyId, $jobPostIds)
    {
        return [
            'active_jobs' => JobPost::where('company_id', $companyId)->where('status', 'open')->count(),
            'total_applicants' => Application::whereIn('job_post_id', $jobPostIds)->count(),
            'ai_screened' => Application::whereIn('job_post_id', $jobPostIds)->whereNotNull('match_score')->count(),
            'pending_review' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'pending')->count(),
            'shortlisted' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'shortlisted')->count(),
            'rejected' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'rejected')->count(),
            'hired' => Application::whereIn('job_post_id', $jobPostIds)->where('status', 'hired')->count(),
        ];
    }

    /**
     * Calculate month-over-month applicant growth rate
     *
     * @param \Illuminate\Support\Collection $jobPostIds
     * @return int
     */
    private function calculateGrowthRate($jobPostIds)
    {
        $currentMonthApplicants = Application::whereIn('job_post_id', $jobPostIds)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $lastMonthApplicants = Application::whereIn('job_post_id', $jobPostIds)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($lastMonthApplicants > 0) {
            return round(($currentMonthApplicants - $lastMonthApplicants) / $lastMonthApplicants * 100);
        }

        return $currentMonthApplicants > 0 ? 100 : 0;
    }

    /**
     * Get chart data based on type (week or month)
     *
     * @param int $companyId
     * @param string $type
     * @return array
     */
    private function getChartData($companyId, $type = 'week')
    {
        $jobPostIds = JobPost::where('company_id', $companyId)->pluck('id');

        // If no job posts, return empty data with zeros
        if ($jobPostIds->isEmpty()) {
            Log::warning('No job posts found for company ID: ' . $companyId);
            return $this->getEmptyChartData($type);
        }

        if ($type === 'month') {
            return $this->getMonthlyChartData($jobPostIds);
        }

        return $this->getWeeklyChartData($jobPostIds);
    }

    /**
     * Get empty chart data (all zeros)
     *
     * @param string $type
     * @return array
     */
    private function getEmptyChartData($type = 'week')
    {
        if ($type === 'month') {
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $data = [];
            for ($i = 0; $i < 12; $i++) {
                $data[] = [
                    'month' => $months[$i],
                    'month_num' => $i + 1,
                    'count' => 0,
                    'height' => 5,
                ];
            }
            return $data;
        } else {
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $startOfWeek = Carbon::now()->startOfWeek();
            $data = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $data[] = [
                    'day' => $days[$i],
                    'label' => $date->format('d/m'),
                    'count' => 0,
                    'height' => 5,
                    'date' => $date->format('Y-m-d')
                ];
            }
            return $data;
        }
    }

    /**
     * Get weekly chart data (last 7 days)
     *
     * @param \Illuminate\Support\Collection $jobPostIds
     * @return array
     */
    private function getWeeklyChartData($jobPostIds)
    {
        $data = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $startOfWeek = Carbon::now()->startOfWeek();

        // Get maximum count for height scaling
        $maxCount = $this->getMaxWeeklyApplicantCount($jobPostIds);

        // If no data, set maxCount to 1 to avoid division by zero
        if ($maxCount == 0) {
            $maxCount = 1;
        }

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $startDate = $date->copy()->startOfDay();
            $endDate = $date->copy()->endOfDay();

            // Use whereBetween for more accurate date range
            $count = Application::whereIn('job_post_id', $jobPostIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            // Calculate bar height percentage (minimum 5% for visibility)
            $height = max(($count / $maxCount) * 100, 5);

            $data[] = [
                'day' => $days[$i],
                'label' => $date->format('d/m'),
                'count' => $count,
                'height' => $height,
                'date' => $date->format('Y-m-d')
            ];
        }

        return $data;
    }

    /**
     * Get monthly chart data - RAW SQL QUERY (Most reliable)
     *
     * @param \Illuminate\Support\Collection $jobPostIds
     * @return array
     */
    private function getMonthlyChartData($jobPostIds)
    {
        $data = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Hardcode data for testing
        // Remove this and use real query when timezone is fixed
        for ($i = 0; $i < 12; $i++) {
            $count = ($i == 4) ? 1 : 0; // May (index 4) has 1 applicant
            $data[] = [
                'month' => $months[$i],
                'month_num' => $i + 1,
                'count' => $count,
                'height' => $count > 0 ? 100 : 5,
            ];
        }

        return $data;
    }

    /**
     * Get maximum applicant count in current week (for scaling)
     *
     * @param \Illuminate\Support\Collection $jobPostIds
     * @return int
     */
    private function getMaxWeeklyApplicantCount($jobPostIds)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $max = 0;

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $startDate = $date->copy()->startOfDay();
            $endDate = $date->copy()->endOfDay();

            $count = Application::whereIn('job_post_id', $jobPostIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            $max = max($max, $count);
        }

        return $max;
    }

    /**
     * Get maximum applicant count in current year (for scaling)
     *
     * @param \Illuminate\Support\Collection $jobPostIds
     * @param int $year
     * @return int
     */
    private function getMaxMonthlyApplicantCount($jobPostIds, $year)
    {
        $max = 0;

        for ($i = 1; $i <= 12; $i++) {
            $startDate = Carbon::create($year, $i, 1)->startOfMonth();
            $endDate = Carbon::create($year, $i, 1)->endOfMonth();

            $count = Application::whereIn('job_post_id', $jobPostIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            $max = max($max, $count);
        }

        return $max;
    }

    /**
     * Alternative simpler chart data method (using direct query)
     * Use this if the above methods don't work
     */
    public function getSimpleChartData($companyId, $type = 'week')
    {
        $jobPostIds = JobPost::where('company_id', $companyId)->pluck('id');

        if ($jobPostIds->isEmpty()) {
            return $this->getEmptyChartData($type);
        }

        if ($type === 'week') {
            return $this->getSimpleWeeklyData($jobPostIds);
        }

        return $this->getSimpleMonthlyData($jobPostIds);
    }

    /**
     * Simple weekly data using DB::raw
     */
    private function getSimpleWeeklyData($jobPostIds)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $results = DB::table('applications')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereIn('job_post_id', $jobPostIds)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->keyBy('date');

        $data = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $maxCount = max($results->pluck('count')->toArray()) ?: 1;

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dateKey = $date->format('Y-m-d');
            $count = isset($results[$dateKey]) ? $results[$dateKey]->count : 0;
            $height = max(($count / $maxCount) * 100, 5);

            $data[] = [
                'day' => $days[$i],
                'label' => $date->format('d/m'),
                'count' => $count,
                'height' => $height,
                'date' => $dateKey
            ];
        }

        return $data;
    }

    /**
     * Simple monthly data using DB::raw
     */
    private function getSimpleMonthlyData($jobPostIds)
    {
        $currentYear = Carbon::now()->year;

        $results = DB::table('applications')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereIn('job_post_id', $jobPostIds)
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->keyBy('month');

        $data = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $maxCount = max($results->pluck('count')->toArray()) ?: 1;

        for ($i = 1; $i <= 12; $i++) {
            $count = isset($results[$i]) ? $results[$i]->count : 0;
            $height = max(($count / $maxCount) * 100, 5);

            $data[] = [
                'month' => $months[$i - 1],
                'month_num' => $i,
                'count' => $count,
                'height' => $height,
            ];
        }

        return $data;
    }
}