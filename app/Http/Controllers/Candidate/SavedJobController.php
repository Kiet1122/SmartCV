<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function toggle(Request $request, $jobId)
    {
        $user = Auth::user();

        // Lệnh toggle() cực kỳ thông minh của Laravel:
        // Nếu đã lưu rồi -> Tự động xóa (Bỏ lưu)
        // Nếu chưa lưu -> Tự động thêm vào (Lưu)
        $user->savedJobs()->toggle($jobId);

        return back()->with('success', 'Đã cập nhật trạng thái lưu công việc!');
    }
}