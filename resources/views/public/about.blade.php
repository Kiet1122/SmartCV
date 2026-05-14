@extends('layouts.master')

@section('title', 'Giới thiệu | SmartCV - Nền tảng tuyển dụng thông minh với AI')

@section('content')
    <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full filter blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-20 md:py-28 text-center">
                <div class="max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-info-circle text-white text-sm"></i>
                        <span class="text-sm font-medium text-white">Về chúng tôi</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6">
                        Cách mạng hóa tuyển dụng <span class="border-b-4 border-white/50">bằng AI</span>
                    </h1>
                    <p class="text-lg text-blue-100 max-w-2xl mx-auto leading-relaxed">
                        SmartCV được xây dựng với sứ mệnh kết nối nhân tài với cơ hội việc làm phù hợp nhất,
                        sử dụng công nghệ trí tuệ nhân tạo tiên tiến nhất.
                    </p>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="order-2 md:order-1">
                        <span
                            class="text-blue-600 text-sm font-semibold tracking-wide uppercase bg-blue-50 px-4 py-1.5 rounded-full">Sứ
                            mệnh</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4 mb-6">Kết nối đúng người - Đúng việc
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Chúng tôi tin rằng mỗi người đều xứng đáng có một công việc phù hợp với đam mê và năng lực của
                            mình.
                            SmartCV ra đời với mục tiêu loại bỏ rào cản trong tuyển dụng, giúp ứng viên tìm được việc làm mơ
                            ước
                            và doanh nghiệp tìm được nhân tài xuất sắc.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Với sức mạnh của trí tuệ nhân tạo, chúng tôi phân tích hàng ngàn điểm dữ liệu để đưa ra
                            những gợi ý chính xác nhất, tiết kiệm thời gian và chi phí cho cả hai bên.
                        </p>
                        <div class="flex items-center gap-6 mt-8">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-users text-blue-500 text-2xl"></i>
                                <div>
                                    <div class="font-bold text-gray-900">10,000+</div>
                                    <div class="text-xs text-gray-500">Ứng viên</div>
                                </div>
                            </div>
                            <div class="w-px h-10 bg-gray-200"></div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-building text-blue-500 text-2xl"></i>
                                <div>
                                    <div class="font-bold text-gray-900">500+</div>
                                    <div class="text-xs text-gray-500">Doanh nghiệp</div>
                                </div>
                            </div>
                            <div class="w-px h-10 bg-gray-200"></div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-blue-500 text-2xl"></i>
                                <div>
                                    <div class="font-bold text-gray-900">95%</div>
                                    <div class="text-xs text-gray-500">Tỷ lệ hài lòng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 md:order-2">
                        <div class="relative">
                            <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-3xl p-8 shadow-xl">
                                <div class="text-center">
                                    <i class="fas fa-quote-left text-blue-300 text-4xl mb-4"></i>
                                    <p class="text-gray-700 italic text-lg leading-relaxed">
                                        "Công nghệ không chỉ thay đổi cách chúng ta làm việc,
                                        mà còn thay đổi cách chúng ta kết nối với nhau."
                                    </p>
                                    <div class="mt-4">
                                        <div class="font-semibold text-gray-900">Đội ngũ SmartCV</div>
                                        <div class="text-sm text-gray-500">Nền tảng tuyển dụng thông minh</div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-200 rounded-full opacity-50 -z-10"></div>
                            <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-indigo-200 rounded-full opacity-50 -z-10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span
                        class="text-blue-600 text-sm font-semibold tracking-wide uppercase bg-blue-50 px-4 py-1.5 rounded-full">Giá
                        trị cốt lõi</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Điều chúng tôi tin tưởng</h2>
                    <p class="text-gray-500 mt-4">Những nguyên tắc định hướng mọi hoạt động của SmartCV</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mb-4 group-hover:from-blue-500 group-hover:to-blue-600 transition-all">
                            <i class="fas fa-lightbulb text-blue-600 text-2xl group-hover:text-white transition-all"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Đổi mới sáng tạo</h3>
                        <p class="text-gray-500 text-sm">Không ngừng cải tiến công nghệ để mang lại trải nghiệm tốt nhất.
                        </p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mb-4 group-hover:from-green-500 group-hover:to-green-600 transition-all">
                            <i class="fas fa-handshake text-green-600 text-2xl group-hover:text-white transition-all"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tin cậy - Minh bạch</h3>
                        <p class="text-gray-500 text-sm">Xây dựng niềm tin thông qua sự minh bạch trong mọi giao dịch.</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-4 group-hover:from-purple-500 group-hover:to-purple-600 transition-all">
                            <i class="fas fa-chart-line text-purple-600 text-2xl group-hover:text-white transition-all"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Phát triển bền vững</h3>
                        <p class="text-gray-500 text-sm">Tạo ra giá trị lâu dài cho cộng đồng và xã hội.</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl flex items-center justify-center mb-4 group-hover:from-amber-500 group-hover:to-amber-600 transition-all">
                            <i class="fas fa-heart text-amber-600 text-2xl group-hover:text-white transition-all"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Lấy khách hàng làm trung tâm</h3>
                        <p class="text-gray-500 text-sm">Luôn lắng nghe và thấu hiểu nhu cầu của người dùng.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Story Timeline -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span
                        class="text-blue-600 text-sm font-semibold tracking-wide uppercase bg-blue-50 px-4 py-1.5 rounded-full">Hành
                        trình phát triển</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Câu chuyện của chúng tôi</h2>
                    <p class="text-gray-500 mt-4">Từ ý tưởng đến hiện thực hóa sứ mệnh kết nối nhân tài</p>
                </div>
                <div class="relative">
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gradient-to-b from-blue-200 via-blue-400 to-blue-200 hidden md:block">
                    </div>

                    <div class="grid md:grid-cols-2 gap-8 relative">
                        <div class="text-right md:pr-12">
                            <div class="bg-blue-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white font-bold mb-4">
                                    1</div>
                                <h3 class="text-xl font-bold text-gray-900">2022 - Ý tưởng hình thành</h3>
                                <p class="text-gray-500 mt-2">Nhóm sáng lập nhận thấy những bất cập trong tuyển dụng truyền
                                    thống và bắt đầu ấp ủ ý tưởng về nền tảng AI.</p>
                            </div>
                        </div>
                        <div class="md:pl-12"></div>

                        <div class="md:pl-12 order-3 md:order-4">
                            <div class="bg-blue-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white font-bold mb-4">
                                    2</div>
                                <h3 class="text-xl font-bold text-gray-900">2023 - Ra mắt phiên bản Beta</h3>
                                <p class="text-gray-500 mt-2">SmartCV chính thức ra mắt với các tính năng phân tích CV cơ
                                    bản, thu hút 500+ người dùng thử nghiệm.</p>
                            </div>
                        </div>
                        <div class="text-right md:pr-12 order-4 md:order-3"></div>

                        <div class="text-right md:pr-12">
                            <div class="bg-blue-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white font-bold mb-4">
                                    3</div>
                                <h3 class="text-xl font-bold text-gray-900">2024 - Mở rộng và phát triển</h3>
                                <p class="text-gray-500 mt-2">Tích hợp AI Matching, kết nối với 200+ doanh nghiệp, phục vụ
                                    hơn 10,000 ứng viên trên toàn quốc.</p>
                            </div>
                        </div>
                        <div class="md:pl-12"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span
                        class="text-blue-600 text-sm font-semibold tracking-wide uppercase bg-blue-50 px-4 py-1.5 rounded-full">Đội
                        ngũ của chúng tôi</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Những người đứng sau SmartCV</h2>
                    <p class="text-gray-500 mt-4">Đam mê, tận tâm và luôn hướng đến sự hoàn hảo</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-lg">
                            NTK
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Kiệt Nguyễn</h3>
                        <p class="text-blue-600 text-sm mb-3">CEO & Founder</p>
                        <p class="text-gray-500 text-sm">10 năm kinh nghiệm trong lĩnh vực AI và tuyển dụng.</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-lg">
                            NTK
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Kiệt Nguyễn</h3>
                        <p class="text-blue-600 text-sm mb-3">CTO</p>
                        <p class="text-gray-500 text-sm">Chuyên gia Machine Learning với bằng Tiến sĩ tại Nhật Bản.</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-lg">
                            NTK
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Kiệt Nguyễn</h3>
                        <p class="text-blue-600 text-sm mb-3">Head of Product</p>
                        <p class="text-gray-500 text-sm">Đam mê tạo ra những sản phẩm có tác động tích cực.</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div
                            class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-lg">
                            NTK
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Kiệt Nguyễn</h3>
                        <p class="text-blue-600 text-sm mb-3">Marketing Director</p>
                        <p class="text-gray-500 text-sm">Chiến lược gia truyền thông với nhiều năm kinh nghiệm.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Tham gia cùng chúng tôi</h2>
                <p class="text-blue-100 text-lg mb-8">Hãy để AI giúp bạn tìm được công việc mơ ước hoặc nhân tài cho doanh
                    nghiệp của bạn.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('candidate.cv.index') }}"
                        class="px-8 py-3.5 bg-white text-blue-600 font-semibold rounded-xl hover:shadow-lg transition-all inline-flex items-center gap-2">
                        <i class="fas fa-cloud-upload-alt"></i>
                        Tải CV lên
                    </a>
                    <a href="{{ route('candidate.companies') }}"
                        class="px-8 py-3.5 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transition-all inline-flex items-center gap-2">
                        <i class="fas fa-building"></i>
                        Xem danh sách công ty
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection