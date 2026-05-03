<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SavedJob;


class SavedJobController extends Controller
{
    /**
     * Hiển thị danh sách việc làm đã lưu
     */
    public function index()
    {
        $user = Auth::user();

        // Lấy danh sách việc làm đã lưu, kèm theo thông tin công ty để hiển thị
        // Phân trang 10 công việc 1 trang
        $savedJobs = $user->savedJobs()->with('company')->paginate(10);

        return view('candidate.saved_jobs', compact('savedJobs'));
    }

    /**
     * Xử lý chức năng Lưu / Bỏ lưu công việc (Toggle)
     */
    public function toggle(JobPost $job)
    {
        try {
            $candidate = auth()->user()->candidateProfile;

            if (!$candidate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy hồ sơ ứng viên'
                ], 404);
            }

            $exists = SavedJob::where('candidate_id', $candidate->id)
                ->where('job_post_id', $job->id)
                ->exists();

            if ($exists) {
                SavedJob::where('candidate_id', $candidate->id)
                    ->where('job_post_id', $job->id)
                    ->delete();

                return response()->json([
                    'success' => true,
                    'saved' => false,
                    'message' => 'Đã xóa khỏi danh sách đã lưu'
                ]);
            } else {
                SavedJob::create([
                    'candidate_id' => $candidate->id,
                    'job_post_id' => $job->id,
                    'created_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'saved' => true,
                    'message' => 'Đã lưu công việc'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}