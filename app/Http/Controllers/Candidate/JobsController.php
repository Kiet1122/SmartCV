<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Application;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobsController extends Controller
{
    /**
     * Hiển thị danh sách việc làm
     */
    public function index(Request $request)
    {
        $query = JobPost::with(['company', 'skills'])
            ->where('status', 'open')
            ->latest();

        // Lọc theo từ khóa
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Lọc theo mức lương
        if ($request->has('salary') && $request->salary) {
            switch ($request->salary) {
                case 'under_10':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(salary_range, "-", 1) AS UNSIGNED) < 10');
                    break;
                case '10_20':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(salary_range, "-", 1) AS UNSIGNED) BETWEEN 10 AND 20');
                    break;
                case '20_30':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(salary_range, "-", 1) AS UNSIGNED) BETWEEN 20 AND 30');
                    break;
                case 'above_30':
                    $query->whereRaw('CAST(SUBSTRING_INDEX(salary_range, "-", 1) AS UNSIGNED) > 30');
                    break;
            }
        }

        // Lọc theo kinh nghiệm
        if ($request->has('experience') && $request->experience) {
            switch ($request->experience) {
                case 'fresh':
                    $query->where('experience_required', '<', 1);
                    break;
                case '1_3':
                    $query->whereBetween('experience_required', [1, 3]);
                    break;
                case '3_5':
                    $query->whereBetween('experience_required', [3, 5]);
                    break;
                case '5_plus':
                    $query->where('experience_required', '>', 5);
                    break;
            }
        }

        // Lọc theo kỹ năng
        if ($request->has('skill') && $request->skill) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->where('skills.id', $request->skill);
            });
        }

        $jobs = $query->paginate(12);
        $skills = Skill::orderBy('name')->get();

        return view('candidate.jobs.jobs_list', compact('jobs', 'skills'));
    }

    /**
     * Hiển thị chi tiết việc làm
     */
    public function show(JobPost $job)
    {
        // Tăng lượt xem
        $job->increment('views_count');

        // Lấy công ty
        $company = Company::find($job->company_id);

        // Lấy kỹ năng của công việc
        $skills = $job->skills;
        $skillIds = $skills->pluck('id')->toArray();

        // Lấy việc làm liên quan (dựa trên kỹ năng và ngành nghề)
        $relatedJobs = JobPost::where('status', 'open')
            ->where('id', '!=', $job->id)
            ->where(function ($q) use ($job, $skillIds, $company) {
                // Cùng công ty
                $q->orWhere('company_id', $job->company_id);

                // Cùng kỹ năng
                if (!empty($skillIds)) {
                    $q->orWhereHas('skills', function ($sq) use ($skillIds) {
                        $sq->whereIn('skills.id', $skillIds);
                    });
                }

                // Cùng ngành nghề (nếu công ty có industry)
                if ($company && $company->industry) {
                    $q->orWhereHas('company', function ($cq) use ($company) {
                        $cq->where('industry', $company->industry);
                    });
                }
            })
            ->with(['company', 'skills'])
            ->limit(6)
            ->get();

        // Kiểm tra xem ứng viên đã lưu công việc này chưa
        $isSaved = false;
        if (auth()->check() && auth()->user()->role === 'candidate') {
            $candidate = auth()->user()->candidateProfile;
            if ($candidate) {
                $isSaved = \App\Models\SavedJob::where('candidate_id', $candidate->id)
                    ->where('job_post_id', $job->id)
                    ->exists();
            }
        }

        return view('candidate.jobs.job_detail', compact('job', 'company', 'skills', 'relatedJobs', 'isSaved'));
    }



    public function apply(Request $request, $id)
    {
        $user = auth()->user();
        $candidate = $user->candidateProfile;
        $job = JobPost::findOrFail($id);
        $cv = $user->cvs()->where('is_default', 1)->first();

        if (!$cv) {
            return back()->with('error', 'Bạn cần chọn CV mặc định trước khi ứng tuyển.');
        }

        $cvData = is_string($cv->parsed_data) ? json_decode($cv->parsed_data, true) : $cv->parsed_data;
        if (is_null($cvData)) {
            $cvData = [];
        }

        $matchScore = 0;
        $rawScore = 0;
        $startTime = microtime(true); // Bắt đầu đo thời gian

        try {
            $response = Http::timeout(120)->post('http://127.0.0.1:8001/api/match-job-to-candidates', [
                'job_description' => (string) $job->description,
                'cvs' => [['id' => (int) $cv->id, 'cv_data' => $cvData]]
            ]);

            if ($response->successful()) {
                $results = $response->json()['results'] ?? [];
                if (!empty($results)) {
                    $matchScore = $results[0]['match_score'] ?? 0;
                    $rawScore = $results[0]['raw_cosine_score'] ?? 0;
                }
            }
        } catch (\Exception $e) {
            Log::error("AI Connection Failed: " . $e->getMessage());
        }

        $endTime = microtime(true);
        // Tính toán thời gian xử lý (giây -> miligiây)
        $processingTime = round(($endTime - $startTime) * 1000);

        // 1. Lưu vào bảng chính: applications
        $application = Application::create([
            'candidate_id' => $candidate->id,
            'job_post_id' => (int) $job->id,
            'cv_id' => (int) $cv->id,
            'match_score' => (float) $matchScore,
            'status' => 'pending'
        ]);

        // 2. Lưu vào bảng: ai_matching_logs
        \DB::table('ai_matching_logs')->insert([
            'application_id' => $application->id,
            'model_used' => 'Llama-3.1-8B', // Hoặc lấy từ config nếu Kiệt có cài đặt
            'raw_score' => (float) $rawScore,
            'final_score' => (float) $matchScore,
            'processing_time_ms' => $processingTime,
            'created_at' => now(),
        ]);

        // 3. Lưu vào bảng: application_logs (Theo cấu trúc bạn gửi)
        // Lưu ý: Nếu bảng này để lưu vết thay đổi trạng thái thì thường có 'old_status', 'new_status'
        // Nhưng dựa theo yêu cầu lưu 'raw_score', 'final_score', mình sẽ lưu theo cấu trúc log AI:
        \DB::table('application_logs')->insert([
            'application_id' => $application->id,
            'old_status' => null,
            'new_status' => 'pending',
            'changed_by' => $user->id,
            'changed_at' => now(),
            // Nếu bảng application_logs của Kiệt có thêm các cột AI như bạn viết ở trên:
            // 'model_used' => 'Llama-3.1-8B',
            // 'raw_score' => (float) $rawScore,
            // 'final_score' => (float) $matchScore,
            // 'processing_time_ms' => $processingTime,
        ]);

        return back()->with('success', 'Ứng tuyển thành công! Điểm phù hợp: ' . $matchScore . '%');
    }

}