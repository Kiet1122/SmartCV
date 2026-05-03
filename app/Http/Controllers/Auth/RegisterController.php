<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\Company; // Giả sử bạn có model Company cho Nhà tuyển dụng
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class RegisterController extends Controller
{
    /**
     * Hiển thị giao diện Đăng ký
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý logic Đăng ký
     */
    public function register(Request $request)
    {
        // 1. Validate dữ liệu đầu vào cực kỳ nghiêm ngặt
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' tự động check khớp với cột password_confirmation
            'role' => ['required', 'in:candidate,recruiter'], // Chỉ chấp nhận 1 trong 2 role này
        ], [
            'email.unique' => 'Email này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role.in' => 'Vai trò không hợp lệ.',
        ]);

        try {
            // 2. Tạo User mới
            $user = clone new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            // 3. Khởi tạo Profile tương ứng dựa trên Role
            if ($user->role === 'candidate') {
                // Tạo hồ sơ ứng viên rỗng
                $profile = new CandidateProfile();
                $profile->user_id = $user->id;
                $profile->save();

            } elseif ($user->role === 'recruiter') {
                // Tạo hồ sơ công ty rỗng (Có thể thêm status = 'pending' ở DB)
                $company = new Company();
                $company->user_id = $user->id;
                $company->company_name = $user->name;
                // $company->status = 'pending'; // Bỏ comment dòng này nếu bạn thiết kế cột status
                $company->save();
            }

            // 4. Đăng nhập ngay lập tức
            Auth::login($user);

            // 5. Điều hướng theo Role
            return match ($user->role) {
                'recruiter' => redirect()->route('recruiter.dashboard')->with('success', 'Đăng ký thành công! Vui lòng cập nhật thông tin công ty để chờ Admin duyệt.'),
                default => redirect()->route('candidate.dashboard')->with('success', 'Chào mừng bạn đến với SmartCV!'),
            };

        } catch (Exception $e) {
            Log::error('Lỗi đăng ký tài khoản: ' . $e->getMessage());
            return back()->withInput()->withErrors(['email' => 'Đã xảy ra lỗi hệ thống, vui lòng thử lại sau.']);
        }
    }
}