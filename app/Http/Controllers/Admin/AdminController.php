<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Skill;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Thống kê tổng quát
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => JobPost::count(),
            'total_applications' => \DB::table('applications')->count(),
            'avg_match_score' => round(\DB::table('ai_matching_logs')->avg('final_score') ?? 0, 1),
        ];

        // 2. Lấy 5 tin tuyển dụng mới nhất
        $recentJobs = JobPost::with('company')->latest()->limit(5)->get();

        // 3. Lấy 5 lượt ứng tuyển có điểm AI cao nhất (Top Matching)
        $topMatches = \DB::table('applications')
            ->join('users', 'applications.candidate_id', '=', 'users.id')
            ->join('job_posts', 'applications.job_post_id', '=', 'job_posts.id')
            ->select('users.name as candidate_name', 'job_posts.title as job_title', 'applications.match_score')
            ->orderByDesc('applications.match_score')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentJobs', 'topMatches'));
    }

    public function users()
    {
        $users = User::latest()->paginate(200);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        // Lấy user kèm theo profile tương ứng
        $user = User::with(['candidateProfile', 'company'])->findOrFail($id);

        // Chuẩn bị dữ liệu chi tiết tùy theo role
        $extraDetails = [];
        if ($user->role === 'candidate') {
            $extraDetails = [
                'Số điện thoại' => $user->candidateProfile->phone ?? 'N/A',
                'Địa chỉ' => $user->candidateProfile->address ?? 'N/A',
                'Giới thiệu' => $user->candidateProfile->bio ?? 'Chưa có dữ liệu',
                'Ngày cập nhật hồ sơ' => $user->candidateProfile->updated_at ? $user->candidateProfile->updated_at->format('d/m/Y') : 'N/A'
            ];
        } elseif ($user->role === 'recruiter') {
            $extraDetails = [
                'Tên công ty' => $user->company->company_name ?? 'N/A',
                'Lĩnh vực' => $user->company->industry ?? 'N/A',
                'Quy mô' => ($user->company->company_size ?? 0) . ' nhân viên',
                'Website' => $user->company->website ?? 'N/A',
                'Địa chỉ công ty' => $user->company->address ?? 'N/A'
            ];
        }

        return view('admin.users.show', compact('user', 'extraDetails'));
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $newRole = $request->input('role');

        // Validate role
        if (!in_array($newRole, ['candidate', 'recruiter', 'admin'])) {
            return back()->with('error', 'Vai trò không hợp lệ.');
        }

        // Không cho phép chuyển Admin thành role khác (bảo vệ)
        if ($user->role === 'admin' && $newRole !== 'admin') {
            return back()->with('error', 'Không thể thay đổi vai trò của tài khoản Admin.');
        }

        // Cập nhật role
        $oldRole = $user->role;
        $user->role = $newRole;
        $user->save();

        // Xử lý khi chuyển từ candidate -> recruiter
        if ($oldRole === 'candidate' && $newRole === 'recruiter') {
            // Tạo company profile nếu chưa có
            if (!$user->company) {
                \App\Models\Company::create([
                    'user_id' => $user->id,
                    'company_name' => 'Công ty của ' . $user->name,
                    'description' => 'Thông tin công ty đang được cập nhật...',
                ]);
            }

            // Xóa candidate profile nếu có (tùy chọn)
            if ($user->candidateProfile) {
                $user->candidateProfile->delete();
            }
        }

        // Xử lý khi chuyển từ recruiter -> candidate
        if ($oldRole === 'recruiter' && $newRole === 'candidate') {
            // Tạo candidate profile nếu chưa có
            if (!$user->candidateProfile) {
                \App\Models\CandidateProfile::create([
                    'user_id' => $user->id,
                    'phone' => null,
                    'address' => null,
                    'bio' => null,
                ]);
            }
        }

        return back()->with('success', 'Đã chuyển đổi vai trò thành công.');
    }

    public function jobs()
    {
        $jobs = JobPost::with('company')->latest()->paginate(20);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function jobDetail(JobPost $job)
    {
        // Load relationships
        $job->load([
            'company',
            'skills',
            'applications' => function ($q) {
                $q->latest()->with('candidate.user');
            }
        ]);

        // Get statistics
        $stats = [
            'total_applications' => $job->applications->count(),
            'avg_match_score' => round($job->applications->avg('match_score') ?? 0, 1),
            'pending_review' => $job->applications->where('status', 'pending')->count(),
            'shortlisted' => $job->applications->where('status', 'shortlisted')->count(),
            'rejected' => $job->applications->where('status', 'rejected')->count(),
            'hired' => $job->applications->where('status', 'hired')->count(),
        ];

        // Get recent applications
        $recentApplications = $job->applications()->latest()->take(5)->get();

        return view('admin.jobs.detail', compact('job', 'stats', 'recentApplications'));
    }

    public function skills()
    {
        $skills = Skill::orderBy('name')->get();
        return view('admin.master_data.skills', compact('skills'));
    }

    public function languages()
    {
        $languages = Language::orderBy('name')->get();
        return view('admin.master_data.languages', compact('languages'));
    }

    // Lưu Skill
    public function storeSkill(Request $request)
    {
        $request->validate(['name' => 'required|unique:skills,name']);
        Skill::create(['name' => $request->name]);
        return back()->with('success', 'Thêm kỹ năng thành công!');
    }

    // Xóa Skill
    public function destroySkill($id)
    {
        Skill::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa kỹ năng.');
    }

    // Tương tự cho Language...
    public function storeLanguage(Request $request)
    {
        $request->validate(['name' => 'required|unique:languages,name']);
        Language::create(['name' => $request->name]);
        return back()->with('success', 'Thêm ngôn ngữ thành công!');
    }

    public function destroyLanguage($id)
    {
        Language::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa ngôn ngữ.');
    }
}