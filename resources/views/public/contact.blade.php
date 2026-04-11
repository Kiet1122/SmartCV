@extends('layouts.master')

@section('content')
    <section class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-16 md:py-20">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ url('/') }}" class="hover:text-blue-600 transition">Trang chủ</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-700 font-medium">Liên hệ</span>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Left side - Contact Info & Form -->
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Liên hệ <span class="text-blue-600">với
                            chúng tôi</span></h1>
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                        Bạn có câu hỏi hoặc cần hỗ trợ? Hãy để lại thông tin, đội ngũ SmartCV sẽ phản hồi trong vòng 24 giờ.
                    </p>

                    <!-- Contact Info Cards -->
                    <div class="grid sm:grid-cols-2 gap-5 mb-10">
                        <div
                            class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Email</h3>
                                <a href="mailto:hello@smartcv.ai"
                                    class="text-gray-500 text-sm hover:text-blue-600 transition">hello@smartcv.ai</a>
                                <p class="text-gray-400 text-xs mt-1">Hỗ trợ 24/7</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fas fa-phone-alt text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Điện thoại</h3>
                                <a href="tel:+842812345678" class="text-gray-500 text-sm hover:text-blue-600 transition">+84
                                    (28) 1234 5678</a>
                                <p class="text-gray-400 text-xs mt-1">T2-T6: 8h - 18h</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fab fa-facebook-messenger text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Messenger</h3>
                                <a href="#" class="text-gray-500 text-sm hover:text-blue-600 transition">m.me/SmartCV.AI</a>
                                <p class="text-gray-400 text-xs mt-1">Trò chuyện trực tiếp</p>
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fab fa-zalo text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Zalo Official</h3>
                                <a href="#" class="text-gray-500 text-sm hover:text-blue-600 transition">SmartCV.VN</a>
                                <p class="text-gray-400 text-xs mt-1">Tư vấn nhanh</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Gửi tin nhắn cho chúng tôi</h2>
                        <form action="#" method="POST">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                        placeholder="Nguyễn Văn A">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span
                                            class="text-red-500">*</span></label>
                                    <input type="email" name="email" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                        placeholder="example@smartcv.ai">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input type="tel" name="phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                    placeholder="0987 654 321">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chủ đề <span
                                        class="text-red-500">*</span></label>
                                <select name="subject" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none">
                                    <option value="">-- Chọn chủ đề --</option>
                                    <option value="Hỗ trợ kỹ thuật">Hỗ trợ kỹ thuật</option>
                                    <option value="Tư vấn tuyển dụng">Tư vấn tuyển dụng</option>
                                    <option value="Hợp tác doanh nghiệp">Hợp tác doanh nghiệp</option>
                                    <option value="Góp ý sản phẩm">Góp ý sản phẩm</option>
                                    <option value="Khác">Khác</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nội dung <span
                                        class="text-red-500">*</span></label>
                                <textarea name="message" rows="5" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none resize-none"
                                    placeholder="Vui lòng nhập chi tiết câu hỏi hoặc yêu cầu của bạn..."></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i> Gửi tin nhắn
                            </button>
                            <p class="text-xs text-gray-400 text-center mt-4">
                                <i class="fas fa-lock-alt"></i> Thông tin của bạn được bảo mật tuyệt đối
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Right side - Map & Office Info -->
                <div>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                        <div class="h-64 bg-gray-200 relative">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1x3919.420273971446!2d106.700682!3d10.775397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3b2c5b9e1f%3A0x5e8b5b5b5b5b5b5b!2zVFAuIEhvw6AgQ2jDrSBNaW5oLCBWaWV0IE5hbQ!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-blue-600"></i> Văn phòng chính
                        </h3>
                        <div class="space-y-3 text-gray-600">
                            <p class="flex gap-3">
                                <i class="fas fa-building text-blue-500 mt-1"></i>
                                <span>Tầng 12, Tòa nhà Smart Tower, 123 Đường Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</span>
                            </p>
                            <p class="flex gap-3">
                                <i class="fas fa-clock text-blue-500 mt-1"></i>
                                <span>Thứ 2 - Thứ 6: 8:00 - 18:00<br>Thứ 7: 9:00 - 12:00</span>
                            </p>
                            <p class="flex gap-3">
                                <i class="fas fa-taxi text-blue-500 mt-1"></i>
                                <span>Thuận tiện di chuyển từ các quận trung tâm, gần ga tàu điện Công viên 23/9</span>
                            </p>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="mt-6 flex gap-4 justify-start">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>

                    <!-- FAQ CTA -->
                    <div class="mt-6 p-5 bg-white rounded-2xl border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                                <i class="fas fa-question-circle text-orange-500 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">Cần hỗ trợ nhanh?</h4>
                                <p class="text-sm text-gray-500">Xem câu hỏi thường gặp hoặc chat với AI trợ lý</p>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">
                                FAQ <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Toast (ẩn, có thể kích hoạt bằng JS khi submit thành công) -->
    <div id="successToast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i>
            <span>Gửi tin nhắn thành công! Chúng tôi sẽ phản hồi sớm.</span>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Simple form submission simulation (có thể thay bằng AJAX thực tế)
        document.querySelector('form')?.addEventListener('submit', function (e) {
            e.preventDefault();
            // Hiển thị toast thông báo
            const toast = document.getElementById('successToast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
            this.reset();
        });
    </script>
@endpush