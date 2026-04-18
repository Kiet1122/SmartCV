<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /**
     * Xử lý logic cập nhật mật khẩu mới vào Database.
     */
    public function reset(Request $request)
    {
        // 1. Validate dữ liệu đầu vào cực kỳ chặt chẽ
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed', // 'confirmed' tự động check khớp với password_confirmation
        ], [
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        // 2. Sử dụng PasswordBroker của Laravel để kiểm tra Token và Email
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Đổi mật khẩu và băm (Hash) lại cho an toàn
                $user->password = Hash::make($password);

                // Reset lại token phiên đăng nhập để các thiết bị cũ bị văng ra (bảo mật)
                $user->setRememberToken(Str::random(60));
                $user->save();

                // Kích hoạt sự kiện đổi mật khẩu thành công của Laravel
                event(new PasswordReset($user));
            }
        );

        // 3. Xử lý kết quả
        if ($status == Password::PASSWORD_RESET) {
            // Đổi pass thành công -> Đẩy về trang Login kèm thông báo xanh lá
            return redirect()->route('login')->with('success', 'Tuyệt vời! Mật khẩu của bạn đã được đặt lại thành công. Vui lòng đăng nhập.');
        }

        // Đổi pass thất bại (Token hết hạn, sai email, hoặc token bị sửa bậy)
        return back()->withErrors(['email' => 'Đường link này đã hết hạn hoặc không hợp lệ. Vui lòng yêu cầu gửi lại email mới.']);
    }
}