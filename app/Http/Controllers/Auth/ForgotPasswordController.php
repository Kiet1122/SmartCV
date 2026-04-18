<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Gửi link đặt lại mật khẩu vào email của người dùng.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // 1. Validate xem email có hợp lệ không
        $request->validate([
            'email' => ['required', 'email']
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Định dạng email không hợp lệ.',
        ]);

        // 2. Sử dụng hệ thống Password Broker của Laravel để gửi email
        // Hàm này tự động tìm User có email này, tạo Token mã hóa, lưu vào bảng `password_reset_tokens` và gửi Mail.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // 3. Kiểm tra kết quả trả về và hiển thị thông báo
        if ($status === Password::RESET_LINK_SENT) {
            // Gửi thành công: Trả về trang cũ kèm biến session 'status' màu xanh lá
            return back()->with(['status' => 'Chúng tôi đã gửi link đặt lại mật khẩu vào email của bạn!']);
        }

        // Gửi thất bại (ví dụ email không tồn tại trong hệ thống): Trả về lỗi màu đỏ
        return back()->withErrors(['email' => 'Chúng tôi không tìm thấy tài khoản nào với email này.']);
    }
}