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
        $candidate = $user->candidateProfile; // Đảm bảo khớp với relation trong Model
        $job = JobPost::findOrFail($id);

        // 1. Lấy CV mặc định - Sử dụng cột 'parsed_data' từ database của bạn
        $cv = $user->cvs()->where('is_default', 1)->first();

        if (!$cv) {
            return back()->with('error', 'Bạn cần chọn CV mặc định trước khi ứng tuyển.');
        }

        // 2. Xử lý parsed_data để tránh lỗi 422
        // Nếu bạn chưa cast cột này trong Model, hãy decode nó
        $cvData = is_string($cv->parsed_data)
            ? json_decode($cv->parsed_data, true)
            : $cv->parsed_data;

        // Nếu parsed_data trong DB đang null, gán mảng rỗng để Python không báo lỗi 'Input should be a valid dictionary'
        if (is_null($cvData)) {
            $cvData = [];
        }

        $matchScore = 0;

        try {
            // 3. Gửi request sang AI (Đảm bảo Port 8003 hoặc port bạn đang chạy uvicorn)
            $response = Http::timeout(120)->post('http://127.0.0.1:8001/api/match-job-to-candidates', [
                'job_description' => (string) $job->description,
                'cvs' => [
                    [
                        'id' => (int) $cv->id,
                        'cv_data' => $cvData // Gửi dữ liệu từ cột parsed_data
                    ]
                ]
            ]);

            if ($response->successful()) {
                // Lấy toàn bộ mảng results
                $results = $response->json()['results'] ?? [];

                // Kiểm tra xem mảng có phần tử không
                if (!empty($results)) {
                    // Lấy match_score của phần tử đầu tiên
                    $matchScore = $results[0]['match_score'] ?? 0;
                }

                Log::info("AI Matching Result for Job {$id}: " . $matchScore);
            } else {
                Log::error("AI Matching 422 Detail: ", $response->json());
            }
        } catch (\Exception $e) {
            Log::error("AI Connection Failed: " . $e->getMessage());
        }

        // 4. Lưu vào bảng applications
        Application::create([
            'candidate_id' => $candidate->id,
            'job_post_id' => (int) $job->id,
            'cv_id' => (int) $cv->id,
            'match_score' => (float) $matchScore, // Ép kiểu về float
            'status' => 'pending'
        ]);

        return back()->with('success', 'Ứng tuyển thành công! Điểm phù hợp: ' . $matchScore . '%');
    }

}