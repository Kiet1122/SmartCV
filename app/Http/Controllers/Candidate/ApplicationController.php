<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\JobPost;
use App\Models\Cv;
use Illuminate\Support\Facades\Http;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $applications = Application::with(['jobPost.company', 'cv'])
            ->where('candidate_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Thay get() bằng paginate() để dùng được hasPages()

        // TRUYỀN BIẾN QUA VIEW
        return view('candidate.applications.index', [
            'applications' => $applications
        ]);
    }

    public function recommendations()
    {
        $user = Auth::user();

        // 1. Lấy CV mặc định hoặc CV mới nhất của ứng viên
        $defaultCv = $user->cvs()->where('is_default', true)->first()
            ?? $user->cvs()->latest()->first();

        // Nếu không có CV thì không thể gợi ý, trả về view kèm danh sách trống
        if (!$defaultCv || !$defaultCv->parsed_data) {
            return view('candidate.applications.recommendations', [
                'recommendedJobs' => collect(),
                'defaultCv' => null
            ]);
        }

        // 2. Lấy tất cả các công việc đang mở (Active)
        $activeJobs = JobPost::with('company')->where('status', 'open')->get();

        if ($activeJobs->isEmpty()) {
            return view('candidate.applications.recommendations', [
                'recommendedJobs' => collect(),
                'defaultCv' => $defaultCv
            ]);
        }

        try {
            // 3. Chuẩn bị payload để gửi sang Python (Port 8001)
            // Lưu ý: Endpoint là /api/match-candidate-to-jobs (1 CV vs N Jobs)
            $jobsPayload = $activeJobs->map(function ($job) {
                return [
                    'id' => $job->id,
                    'description' => $job->title . ' ' . $job->description
                ];
            })->toArray();

            // 4. Gọi sang Microservice Python
            $response = Http::timeout(20)->post('http://localhost:8001/api/match-candidate-to-jobs', [
                'cv_data' => $defaultCv->parsed_data,
                'jobs' => $jobsPayload
            ]);

            if ($response->successful()) {
                $aiResults = $response->json('results'); // Mảng: [['job_id' => 1, 'match_score' => 85.5], ...]

                // Chuyển mảng kết quả thành dạng dễ tra cứu [id => score]
                $scoreMap = collect($aiResults)->pluck('match_score', 'job_id');

                // 5. Gán điểm Match thật vào danh sách Job và sắp xếp
                $recommendedJobs = $activeJobs->map(function ($job) use ($scoreMap) {
                    $job->match_score = $scoreMap->get($job->id, 0);
                    return $job;
                })->filter(function ($job) {
                    return $job->match_score > 0; // Chỉ hiện những Job có độ phù hợp > 0%
                })->sortByDesc('match_score')->values();

            } else {
                // Nếu AI Service lỗi, fallback về mảng rỗng hoặc logic khác để tránh chết trang
                $recommendedJobs = collect();
                session()->flash('error', 'Không thể kết nối với hệ thống gợi ý AI hiện tại.');
            }

        } catch (\Exception $e) {
            $recommendedJobs = collect();
            \Log::error("AI Matching Error: " . $e->getMessage());
        }

        // 6. TRUYỀN BIẾN QUA VIEW
        return view('candidate.applications.recommendations', [
            'recommendedJobs' => $recommendedJobs,
            'defaultCv' => $defaultCv
        ]);
    }


}