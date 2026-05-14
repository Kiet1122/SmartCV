<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function aiMatching()
    {
        // Lấy log kèm thông tin ứng viên và công việc để xem cho dễ
        $logs = DB::table('ai_matching_logs')
            ->join('applications', 'ai_matching_logs.application_id', '=', 'applications.id')
            ->join('job_posts', 'applications.job_post_id', '=', 'job_posts.id')
            ->select('ai_matching_logs.*', 'job_posts.title as job_title')
            ->latest('ai_matching_logs.created_at')
            ->paginate(30);

        return view('admin.logs.ai_matching', compact('logs'));
    }
}