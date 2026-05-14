<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Application Result</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#2563eb,#3b82f6);padding:32px;text-align:center;color:white;">
                            <h1 style="margin:0;font-size:28px;">
                                SmartCV
                            </h1>

                            <p style="margin-top:10px;font-size:15px;opacity:0.9;">
                                Kết quả ứng tuyển của bạn
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 35px;color:#374151;line-height:1.8;">

                            <h2 style="margin-top:0;font-size:24px;color:#111827;">
                                Chào {{ $applicant->candidate->user->name }},
                            </h2>

                            @if($status == 'accepted')

                                <div
                                    style="background:#ecfdf5;border:1px solid #10b981;padding:20px;border-radius:12px;margin:25px 0;">

                                    <h3 style="margin-top:0;color:#059669;">
                                        🎉 Chúc mừng!
                                    </h3>

                                    <p style="margin-bottom:0;">
                                        Hồ sơ của bạn cho vị trí
                                        <strong>{{ $applicant->jobPost->title }}</strong>
                                        đã được công ty chấp nhận.
                                    </p>
                                </div>

                                <p>
                                    Chúng tôi sẽ sớm liên hệ với bạn để trao đổi thêm
                                    về lịch phỏng vấn và các bước tiếp theo.
                                </p>

                            @else

                                <div
                                    style="background:#fef2f2;border:1px solid #ef4444;padding:20px;border-radius:12px;margin:25px 0;">

                                    <h3 style="margin-top:0;color:#dc2626;">
                                        Kết quả ứng tuyển
                                    </h3>

                                    <p style="margin-bottom:0;">
                                        Sau quá trình xem xét, chúng tôi nhận thấy hồ sơ của bạn
                                        hiện chưa phù hợp với vị trí
                                        <strong>{{ $applicant->jobPost->title }}</strong>.
                                    </p>
                                </div>

                                <p>
                                    Cảm ơn bạn đã quan tâm đến công ty và dành thời gian ứng tuyển.
                                    Chúc bạn sớm tìm được công việc phù hợp trong tương lai.
                                </p>

                            @endif

                            <!-- Footer -->
                            <p style="margin-top:35px;">
                                Trân trọng,<br>
                                <strong>{{ auth()->user()->company->company_name }}</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;padding:20px;text-align:center;font-size:13px;color:#9ca3af;">
                            © {{ date('Y') }} SmartCV. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>