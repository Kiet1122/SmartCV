<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Hiển thị giao diện form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý dữ liệu form đăng nhập gửi lên
     */
    public function login(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        // 2. Lấy trạng thái nút "Ghi nhớ đăng nhập" (Remember me)
        $remember = $request->boolean('remember');

        // 3. Thực hiện xác thực (Check DB)
        if (Auth::attempt($credentials, $remember)) {
            // Đăng nhập thành công: Tạo lại session để chống lỗi bảo mật (Session Fixation)
            $request->session()->regenerate();

            // 4. Phân luồng điều hướng theo Role (Vai trò)
            $user = Auth::user();
            return match ($user->role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'recruiter' => redirect()->intended('/recruiter/dashboard'),
                default => redirect()->intended('/candidate/dashboard'),
            };
        }

        // 5. Nếu sai email hoặc mật khẩu: Đẩy ngược về form kèm thông báo lỗi
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email'); // Giữ lại email người dùng vừa nhập để họ đỡ phải gõ lại
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Xóa sạch session cũ và tạo token CSRF mới để bảo mật
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}