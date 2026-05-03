<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    /**
     * Hiển thị trang liên hệ
     */
    public function index()
    {
        $settings = [
            'email' => 'company@smartcv.vn',
            'phone' => '+84 (28) 1234 5678',
            'address' => 'Tầng 12, Tòa nhà Smart Tower, 123 Đường Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh',
            'working_hours' => 'Thứ 2 - Thứ 6: 8:00 - 18:00, Thứ 7: 9:00 - 12:00',
            'facebook' => 'https://facebook.com/smartcv',
            'zalo' => 'https://zalo.me/smartcv',
            'messenger' => 'https://m.me/smartcv',
        ];

        return view('public.contact', compact('settings'));
    }

    /**
     * Xử lý form liên hệ
     */
    public function submit(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Lưu vào database
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            Mail::to(config('mail.admin_email', 'admin@smartcv.ai'))->send(new ContactMail($contact));
        } catch (\Exception $e) {
            \Log::error('Send contact email failed: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 24 giờ.'
            ]);
        }

        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 24 giờ.');
    }
}