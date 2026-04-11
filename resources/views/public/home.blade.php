@extends('layouts.master')

@section('content')
    <main>
        <section class="relative overflow-hidden bg-white hero-bg-gradient">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-16 md:py-24 lg:py-28">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="text-center md:text-left">
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
                            Tìm Việc Mơ Ước <span class="text-blue-600">Cùng AI</span>
                        </h1>
                        <p class="text-lg text-gray-500 mt-6 max-w-lg mx-auto md:mx-0 leading-relaxed">
                            SmartCV giúp kết nối CV của bạn với những công việc phù hợp nhất bằng công nghệ AI thông minh.
                            Tiếp cận vai trò mới nhanh hơn bao giờ hết.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center md:justify-start">
                            <button
                                class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition-all btn-transition flex items-center justify-center gap-2">
                                <i class="fas fa-cloud-upload-alt"></i> Tải CV lên
                            </button>
                            <button
                                class="px-8 py-3.5 bg-white border border-gray-300 hover:border-blue-400 hover:text-blue-600 text-gray-700 font-semibold rounded-xl shadow-sm transition-all btn-transition flex items-center justify-center gap-2">
                                <i class="fas fa-briefcase"></i> Duyệt việc làm
                            </button>
                        </div>
                        <div class="flex items-center gap-4 mt-8 text-sm text-gray-400 justify-center md:justify-start">
                            <span class="flex items-center gap-1"><i class="fas fa-check-circle text-green-500"></i> Quét CV
                                miễn phí</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-1"><i class="fas fa-robot text-blue-500"></i> Công nghệ
                                AI</span>
                        </div>
                    </div>
                    <div class="hidden md:flex justify-center">
                        <div class="relative w-full max-w-md">
                            <div class="bg-blue-50 rounded-3xl p-6 shadow-xl border border-blue-100/60">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-file-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold">CV_NguyenVanA.pdf</p>
                                        <p class="text-xs text-gray-500">Điểm AI: 94% phù hợp</p>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full w-[94%] bg-blue-500 rounded-full"></div>
                                </div>
                                <div class="mt-5 text-sm text-gray-600">
                                    <i class="fas fa-magic text-blue-500 mr-1"></i> Top 3 gợi ý việc làm sẵn sàng
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-blue-600 text-sm font-semibold tracking-wide uppercase">Tại sao chọn SmartCV</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Tính năng AI mạnh mẽ</h2>
                    <p class="text-gray-500 mt-4">Công nghệ tiên tiến giúp chuyển đổi quy trình tuyển dụng và tìm kiếm việc
                        làm.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">
                    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100 card-hover">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl mb-5">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Phân tích CV bằng AI</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Trích xuất kỹ năng, kinh nghiệm với độ chính
                            xác 99% nhờ học sâu.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100 card-hover">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl mb-5">
                            <i class="fas fa-arrows-alt"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Ghép nối thông minh</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Thuật toán thời gian thực kết nối hồ sơ của
                            bạn với vị trí phù hợp.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100 card-hover">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl mb-5">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Ứng tuyển nhanh</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Một chạm ứng tuyển, tự động điền form, tiết
                            kiệm thời gian.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100 card-hover">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl mb-5">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Gợi ý bằng AI</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Đề xuất lộ trình sự nghiệp dựa trên xu hướng
                            thị trường.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="flex flex-wrap justify-between items-end mb-10">
                    <div>
                        <span class="text-blue-600 text-sm font-semibold tracking-wide uppercase">Việc làm mới nhất</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-1">Việc làm được chọn riêng cho bạn</h2>
                    </div>
                    <a href="#" class="text-blue-600 font-medium hover:underline flex items-center gap-1 mt-2 sm:mt-0">
                        Xem tất cả <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 job-card transition-all shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Kỹ sư Frontend cao cấp</h3>
                                <div class="flex items-center gap-1 text-gray-500 text-sm mt-1">
                                    <i class="fas fa-building"></i> <span>TechCorp · TP.HCM</span>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Toàn thời
                                gian</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-gray-600 text-sm">
                            <i class="fas fa-dollar-sign"></i> 1.800 - 2.500 USD
                            <span class="mx-1 w-1 h-1 bg-gray-300 rounded-full"></span>
                            <i class="fas fa-map-marker-alt"></i> Linh hoạt
                        </div>
                        <p class="text-gray-500 text-sm mt-3">React, TypeScript, Tailwind, GraphQL. Xây dựng dashboard AI
                            thế hệ mới.</p>
                        <div class="mt-5">
                            <button
                                class="w-full text-blue-600 font-medium hover:bg-blue-50 px-4 py-2 rounded-xl transition border border-blue-200">Ứng
                                tuyển →</button>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 job-card transition-all shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Chuyên gia dữ liệu - ML</h3>
                                <div class="flex items-center gap-1 text-gray-500 text-sm mt-1">
                                    <i class="fas fa-building"></i> <span>AnalytixLabs · Remote</span>
                                </div>
                            </div>
                            <span
                                class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">Remote</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-gray-600 text-sm">
                            <i class="fas fa-dollar-sign"></i> 2.000 - 2.800 USD
                            <span class="mx-1 w-1 h-1 bg-gray-300 rounded-full"></span>
                            <i class="fas fa-globe"></i> Toàn cầu
                        </div>
                        <p class="text-gray-500 text-sm mt-3">Python, TensorFlow, NLP, LLMs. Tham gia nhóm nghiên cứu tuyển
                            dụng AI.</p>
                        <div class="mt-5">
                            <button
                                class="w-full text-blue-600 font-medium hover:bg-blue-50 px-4 py-2 rounded-xl transition border border-blue-200">Ứng
                                tuyển →</button>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 job-card transition-all shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Quản lý sản phẩm</h3>
                                <div class="flex items-center gap-1 text-gray-500 text-sm mt-1">
                                    <i class="fas fa-building"></i> <span>InnovateAI · Hà Nội</span>
                                </div>
                            </div>
                            <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-2 py-1 rounded-full">Giám
                                đốc</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-gray-600 text-sm">
                            <i class="fas fa-dollar-sign"></i> 2.200 - 3.000 USD
                            <span class="mx-1 w-1 h-1 bg-gray-300 rounded-full"></span>
                            <i class="fas fa-building"></i> Tại văn phòng
                        </div>
                        <p class="text-gray-500 text-sm mt-3">Dẫn dắt lộ trình sản phẩm AI, làm việc với nhóm đa chức năng.
                        </p>
                        <div class="mt-5">
                            <button
                                class="w-full text-blue-600 font-medium hover:bg-blue-50 px-4 py-2 rounded-xl transition border border-blue-200">Ứng
                                tuyển →</button>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 job-card transition-all shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Kỹ sư Backend (Go)</h3>
                                <div class="flex items-center gap-1 text-gray-500 text-sm mt-1">
                                    <i class="fas fa-building"></i> <span>CloudScale · Đà Nẵng</span>
                                </div>
                            </div>
                            <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">Hợp
                                đồng</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-gray-600 text-sm">
                            <i class="fas fa-dollar-sign"></i> 1.500 - 2.200 USD
                            <span class="mx-1 w-1 h-1 bg-gray-300 rounded-full"></span>
                            <i class="fas fa-microchip"></i> Microservices
                        </div>
                        <p class="text-gray-500 text-sm mt-3">K8s, gRPC, hệ thống hiệu suất cao. Remote trong khung giờ Việt
                            Nam.</p>
                        <div class="mt-5">
                            <button
                                class="w-full text-blue-600 font-medium hover:bg-blue-50 px-4 py-2 rounded-xl transition border border-blue-200">Ứng
                                tuyển →</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection