@extends('layouts.master')

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-16 md:py-24">
            <div class="text-center max-w-3xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fas fa-brain"></i>
                    <span>Chuyển đổi số nhân sự</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Về <span class="text-blue-600">SmartCV</span>
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Chúng tôi kiến tạo nền tảng kết nối việc làm thông minh,
                    nơi AI đồng hành cùng bạn trên mọi chặng đường sự nghiệp.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="grid md:grid-cols-2 gap-8">
                <div
                    class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-8 border border-blue-100 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center mb-5">
                        <i class="fas fa-bullseye text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Sứ mệnh</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Mang đến giải pháp tuyển dụng thông minh, kết nối đúng người - đúng việc,
                        giúp ứng viên tiết kiệm thời gian tìm kiếm và doanh nghiệp tối ưu hóa quy trình tuyển dụng.
                    </p>
                </div>
                <div
                    class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-8 border border-indigo-100 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center mb-5">
                        <i class="fas fa-eye text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Tầm nhìn</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Trở thành nền tảng kết nối việc làm hàng đầu Đông Nam Á dựa trên AI,
                        nơi mọi người đều có cơ hội tiếp cận công việc phù hợp nhất với năng lực.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Timeline -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-blue-600 text-sm font-semibold tracking-wide uppercase">Hành trình phát triển</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Câu chuyện SmartCV</h2>
                <p class="text-gray-500 mt-4">Từ ý tưởng đến hiện thực, chúng tôi không ngừng đổi mới mỗi ngày</p>
            </div>

            <div class="relative">
                <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-blue-200"></div>

                <div class="grid gap-8">
                    <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-12">
                        <div class="md:w-1/2 md:text-right">
                            <div
                                class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                                <div class="flex items-center gap-3 mb-3 md:justify-end">
                                    <span class="text-3xl font-bold text-blue-600">2022</span>
                                    <i class="fas fa-rocket text-blue-500 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Khởi nghiệp</h3>
                                <p class="text-gray-600">Thành lập SmartCV với sứ mệnh ứng dụng AI vào lĩnh vực nhân sự, bắt
                                    đầu với đội ngũ 5 thành viên.</p>
                            </div>
                        </div>
                        <div
                            class="hidden md:block w-8 h-8 rounded-full bg-blue-500 border-4 border-white shadow-md absolute left-1/2 transform -translate-x-1/2">
                        </div>
                        <div class="md:w-1/2"></div>
                    </div>

                    <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-12">
                        <div class="md:w-1/2"></div>
                        <div
                            class="hidden md:block w-8 h-8 rounded-full bg-blue-500 border-4 border-white shadow-md absolute left-1/2 transform -translate-x-1/2">
                        </div>
                        <div class="md:w-1/2">
                            <div
                                class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="text-3xl font-bold text-blue-600">2023</span>
                                    <i class="fas fa-users text-blue-500 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Mở rộng quy mô</h3>
                                <p class="text-gray-600">Đạt 100.000+ người dùng, hợp tác với 500+ doanh nghiệp, ra mắt tính
                                    năng AI CV Parsing.</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-12">
                        <div class="md:w-1/2 md:text-right">
                            <div
                                class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                                <div class="flex items-center gap-3 mb-3 md:justify-end">
                                    <span class="text-3xl font-bold text-blue-600">2024</span>
                                    <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Tăng trưởng vượt bậc</h3>
                                <p class="text-gray-600">Mở rộng thị trường ra khu vực phía Nam, ra mắt ứng dụng mobile và
                                    tính năng Smart Job Matching.</p>
                            </div>
                        </div>
                        <div
                            class="hidden md:block w-8 h-8 rounded-full bg-blue-500 border-4 border-white shadow-md absolute left-1/2 transform -translate-x-1/2">
                        </div>
                        <div class="md:w-1/2"></div>
                    </div>

                    <div class="relative flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-12">
                        <div class="md:w-1/2"></div>
                        <div
                            class="hidden md:block w-8 h-8 rounded-full bg-blue-500 border-4 border-white shadow-md absolute left-1/2 transform -translate-x-1/2">
                        </div>
                        <div class="md:w-1/2">
                            <div
                                class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="text-3xl font-bold text-blue-600">2025</span>
                                    <i class="fas fa-globe-asia text-blue-500 text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Vươn tầm quốc tế</h3>
                                <p class="text-gray-600">Mở rộng hợp tác quốc tế, ra mắt hệ sinh thái AI toàn diện cho thị
                                    trường nhân sự.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-blue-600 text-sm font-semibold tracking-wide uppercase">Giá trị cốt lõi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Điều chúng tôi tin tưởng</h2>
                <p class="text-gray-500 mt-4">5 giá trị định hình mọi hoạt động của SmartCV</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <div class="text-center group">
                    <div
                        class="w-20 h-20 rounded-full bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fas fa-lightbulb text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Đổi mới sáng tạo</h3>
                    <p class="text-sm text-gray-500">Không ngừng cập nhật công nghệ mới</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-20 h-20 rounded-full bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Bảo mật tuyệt đối</h3>
                    <p class="text-sm text-gray-500">Dữ liệu người dùng được bảo vệ</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-20 h-20 rounded-full bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fas fa-handshake text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Đồng hành</h3>
                    <p class="text-sm text-gray-500">Cùng phát triển với đối tác</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-20 h-20 rounded-full bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fas fa-chart-simple text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Hiệu quả</h3>
                    <p class="text-sm text-gray-500">Tiết kiệm thời gian, tối ưu chi phí</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-20 h-20 rounded-full bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fas fa-heart text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Tận tâm</h3>
                    <p class="text-sm text-gray-500">Luôn lắng nghe và thấu hiểu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-blue-600 text-sm font-semibold tracking-wide uppercase">Đội ngũ</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Những người đứng sau SmartCV</h2>
                <p class="text-gray-500 mt-4">Chúng tôi là tập thể đam mê công nghệ và khát khao tạo ra giá trị</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div
                        class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition">
                        <i class="fas fa-user-tie text-white text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Nguyễn Tất Kiệt</h3>
                    <p class="text-blue-600 text-sm font-medium mb-2">CEO & Founder</p>
                    <p class="text-gray-500 text-sm">10+ năm kinh nghiệm trong lĩnh vực AI và nhân sự</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition">
                        <i class="fas fa-laptop-code text-white text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Nguyễn Tất Kiệt</h3>
                    <p class="text-blue-600 text-sm font-medium mb-2">CTO</p>
                    <p class="text-gray-500 text-sm">Chuyên gia Machine Learning, từng làm tại Google</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-32 h-32 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition">
                        <i class="fas fa-chart-line text-white text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Nguyễn Tất Kiệt</h3>
                    <p class="text-blue-600 text-sm font-medium mb-2">CPO</p>
                    <p class="text-gray-500 text-sm">Đam mê xây dựng sản phẩm có tác động xã hội</p>
                </div>
                <div class="text-center group">
                    <div
                        class="w-32 h-32 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-105 transition">
                        <i class="fas fa-handshake text-white text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Nguyễn Tất Kiệt</h3>
                    <p class="text-blue-600 text-sm font-medium mb-2">CGO</p>
                    <p class="text-gray-500 text-sm">Xây dựng hệ sinh thái đối tác bền vững</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">500+</div>
                    <p class="text-gray-600 font-medium">Doanh nghiệp đối tác</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">100K+</div>
                    <p class="text-gray-600 font-medium">Người dùng tin tưởng</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">98%</div>
                    <p class="text-gray-600 font-medium">Độ chính xác của AI</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">24/7</div>
                    <p class="text-gray-600 font-medium">Hỗ trợ khách hàng</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Sẵn sàng đồng hành cùng SmartCV?</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                Hãy bắt đầu hành trình tìm kiếm công việc mơ ước hoặc kết nối với ứng viên tiềm năng ngay hôm nay.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#"
                    class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-100 transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-cloud-upload-alt"></i> Tải CV ngay
                </a>
                <a href="{{ url('/contact') }}"
                    class="px-8 py-3 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transition flex items-center justify-center gap-2">
                    <i class="fas fa-envelope"></i> Liên hệ tư vấn
                </a>
            </div>
        </div>
    </section>
@endsection