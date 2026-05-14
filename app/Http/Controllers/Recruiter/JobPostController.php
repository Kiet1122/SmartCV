<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Skill;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    /**
     * Display a listing of jobs for the current recruiter's company
     */
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('recruiter.company.setup')
                ->with('error', 'Vui lòng cập nhật thông tin công ty trước.');
        }

        $companyId = $company->id;

        // Get all jobs for this company with application count
        $jobs = JobPost::where('company_id', $companyId)
            ->withCount('applications')
            ->with('skills')
            ->latest()
            ->get();

        // Calculate total applicants across all jobs
        $totalApplicants = Application::whereIn('job_post_id', JobPost::where('company_id', $companyId)->pluck('id'))
            ->count();

        return view('recruiter.jobs.index', compact('jobs', 'totalApplicants'));
    }

    /**
     * Show the form for creating a new job
     */
    public function create()
    {
        $skills = Skill::orderBy('name')->get();
        return view('recruiter.jobs.form', compact('skills'));
    }

    /**
     * Show the form for editing a job
     */
    public function edit(JobPost $job)
    {
        $skills = Skill::orderBy('name')->get();
        $selectedSkills = $job->skills->pluck('id')->toArray();

        return view('recruiter.jobs.form', compact('job', 'skills', 'selectedSkills'));
    }

    /**
     * Store a newly created job
     */
    public function store(Request $request)
    {
        $this->validateJob($request);

        $companyId = Auth::user()->company->id;

        // Create job with initial status 'pending'
        $job = JobPost::create([
            'company_id' => $companyId,
            'title' => $request->title,
            'description' => $request->description,
            'experience_required' => $request->experience_required ?? null,
            'salary_range' => $request->salary_range ?? null,
            'education_required' => $request->education_required ?? null,
            'status' => 'pending',
        ]);

        // Sync skills
        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        // Run AI check
        $result = $this->runAICheck($job);

        return redirect()->route('recruiter.jobs.index')
            ->with($result['type'], $result['msg']);
    }

    /**
     * Update the specified job
     */
    public function update(Request $request, JobPost $job)
    {
        $this->validateJob($request);

        // Verify ownership
        if ($job->company_id !== Auth::user()->company->id) {
            return redirect()->route('recruiter.jobs.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa tin này.');
        }

        // Update job, reset status to pending for re-review
        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'experience_required' => $request->experience_required ?? null,
            'salary_range' => $request->salary_range ?? null,
            'education_required' => $request->education_required ?? null,
            'status' => 'pending',
        ]);

        // Sync skills
        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        // Run AI check again
        $result = $this->runAICheck($job);

        return redirect()->route('recruiter.jobs.index')
            ->with($result['type'], $result['msg']);
    }

    /**
     * Close the specified job (stop accepting applications)
     */
    public function close(JobPost $job)
    {
        // Check ownership
        if ($job->company_id !== Auth::user()->company->id) {
            return redirect()->route('recruiter.jobs.index')
                ->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $job->update(['status' => 'closed']);

        return redirect()->route('recruiter.jobs.index')
            ->with('success', 'Tin tuyển dụng đã được đóng thành công.');
    }

    /**
     * Remove the specified job
     */
    public function destroy(JobPost $job)
    {
        // Check ownership
        if ($job->company_id !== Auth::user()->company->id) {
            return redirect()->route('recruiter.jobs.index')
                ->with('error', 'Bạn không có quyền xóa tin này.');
        }

        $job->delete();

        return redirect()->route('recruiter.jobs.index')
            ->with('success', 'Đã xóa tin tuyển dụng.');
    }

    /**
     * Validate job request
     */
    private function validateJob(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'experience_required' => 'nullable|numeric|min:0|max:50',
            'salary_range' => 'nullable|string|max:100',
            'education_required' => 'nullable|string|max:100',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);
    }

    /**
     * Run AI check for job posting
     */
    private function runAICheck(JobPost $job)
    {
        $type = 'info';
        $msg = 'Tin đang trong quá trình kiểm duyệt bởi AI.';

        try {
            // Call Llama 3.1 Microservice (Port 8003)
            $response = Http::timeout(30)->post('http://127.0.0.1:8003/api/check-job', [
                'title' => $job->title,
                'description' => $job->description ?? '',
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['is_safe']) && $result['is_safe'] === true) {
                    $job->update(['status' => 'open']);
                    $type = 'success';
                    $msg = '✅ Kiểm duyệt hoàn tất. Tin tuyển dụng hiện đang được hiển thị!';
                } else {
                    $job->update(['status' => 'rejected']);
                    $type = 'error';
                    $reason = $result['reason'] ?? 'Nội dung không hợp lệ';
                    $msg = '❌ Tin bị từ chối do vi phạm: ' . $reason;
                }
            } else {
                // AI service error - temporary allow
                $job->update(['status' => 'open']);
                $type = 'warning';
                $msg = '⚠️ Hệ thống AI đang bận, tin đã được hiển thị tạm thời.';
            }
        } catch (\Exception $e) {
            $job->update(['status' => 'open']);
            $type = 'warning';
            $msg = '⚠️ Hệ thống kiểm duyệt gặp sự cố, tin của bạn đã được đăng.';
            Log::error("AI Check failed for job {$job->id}: " . $e->getMessage());
        }

        return ['type' => $type, 'msg' => $msg];
    }
}