@extends('layouts.master')

@section('title', 'Trang chủ | SmartCV - Tìm việc thông minh với AI')

@section('content')
    <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>

            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-16 md:py-24 lg:py-28 relative z-10">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Left Column -->
                    <div class="text-center md:text-left">
                        <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span class="text-sm font-medium text-blue-700">Hơn 500+ việc làm chất lượng</span>
                        </div>
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
                            Tìm Việc Mơ Ước <span
                                class="text-blue-600 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Cùng
                                AI</span>
                        </h1>
                        <p class="text-lg text-gray-500 mt-6 max-w-lg mx-auto md:mx-0 leading-relaxed">
                            SmartCV giúp kết nối CV của bạn với những công việc phù hợp nhất bằng công nghệ AI thông minh.
                            Tiếp cận vai trò mới nhanh hơn bao giờ hết.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center md:justify-start">
                            <a href="{{ route('candidate.cv.index') }}"
                                class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">cloud_upload</span>
                                Tải CV lên
                            </a>
                            <a href="{{ route('candidate.jobs.index') }}"
                                class="px-8 py-3.5 bg-white border border-gray-300 hover:border-blue-400 hover:text-blue-600 text-gray-700 font-semibold rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">search</span>
                                Duyệt việc làm
                            </a>
                        </div>
                        <div
                            class="flex flex-wrap items-center gap-4 mt-8 text-sm text-gray-400 justify-center md:justify-start">
                            <span class="flex items-center gap-1"><span
                                    class="material-symbols-outlined text-green-500 text-base">check_circle</span> Quét CV
                                miễn phí</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-1"><span
                                    class="material-symbols-outlined text-blue-500 text-base">psychology</span> Công nghệ
                                AI</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-1"><span
                                    class="material-symbols-outlined text-amber-500 text-base">bolt</span> Kết nối
                                nhanh</span>
                        </div>
                    </div>

                    <!-- Right Column - Demo CV Card -->
                    <div class="hidden md:flex justify-center">
                        <div class="relative w-full max-w-md animate-float">
                            <div class="bg-white rounded-3xl p-6 shadow-2xl border border-gray-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                                        <span class="material-symbols-outlined text-white">description</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">CV_NguyenVanA.pdf</p>
                                        <p class="text-xs text-gray-500">Điểm AI: 94% phù hợp</p>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full w-[94%] bg-gradient-to-r from-blue-500 to-blue-600 rounded-full">
                                    </div>
                                </div>
                                <div class="mt-5 flex items-center gap-2 text-sm text-gray-600">
                                    <span class="material-symbols-outlined text-blue-500 text-base">auto_awesome</span>
                                    <span>Top 3 gợi ý việc làm sẵn sàng</span>
                                </div>
                                <div class="mt-4 flex gap-2">
                                    <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full">Frontend
                                        Developer</span>
                                    <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-full">React
                                        Expert</span>
                                </div>
                            </div>
                            <!-- Decorative dots -->
                            <div class="absolute -top-4 -right-4 w-20 h-20 bg-blue-100 rounded-full opacity-50 -z-10"></div>
                            <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-indigo-100 rounded-full opacity-50 -z-10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span
                        class="text-blue-600 text-sm font-semibold tracking-wide uppercase bg-blue-50 px-4 py-1.5 rounded-full">Tại
                        sao chọn SmartCV</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Tính năng AI mạnh mẽ</h2>
                    <p class="text-gray-500 mt-4">Công nghệ tiên tiến giúp chuyển đổi quy trình tuyển dụng và tìm kiếm việc
                        làm.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">
                    <div
                        class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 group-hover:from-blue-500 group-hover:to-blue-600 flex items-center justify-center text-blue-600 group-hover:text-white text-2xl mb-5 transition-all">
                            <span class="material-symbols-outlined">analytics</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Phân tích CV bằng AI</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Trích xuất kỹ năng, kinh nghiệm với độ chính
                            xác 99% nhờ học sâu.</p>
                    </div>
                    <div
                        class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 group-hover:from-blue-500 group-hover:to-blue-600 flex items-center justify-center text-blue-600 group-hover:text-white text-2xl mb-5 transition-all">
                            <span class="material-symbols-outlined">sync_alt</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Ghép nối thông minh</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Thuật toán thời gian thực kết nối hồ sơ của
                            bạn với vị trí phù hợp.</p>
                    </div>
                    <div
                        class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 group-hover:from-blue-500 group-hover:to-blue-600 flex items-center justify-center text-blue-600 group-hover:text-white text-2xl mb-5 transition-all">
                            <span class="material-symbols-outlined">flash_on</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Ứng tuyển nhanh</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Một chạm ứng tuyển, tự động điền form, tiết
                            kiệm thời gian.</p>
                    </div>
                    <div
                        class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 group-hover:from-blue-500 group-hover:to-blue-600 flex items-center justify-center text-blue-600 group-hover:text-white text-2xl mb-5 transition-all">
                            <span class="material-symbols-outlined">recommend</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800">Gợi ý bằng AI</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Đề xuất lộ trình sự nghiệp dựa trên xu hướng
                            thị trường.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Jobs Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="flex flex-wrap justify-between items-end mb-12">
                    <div>
                        <span
                            class="text-blue-600 text-sm font-semibold tracking-wide uppercase bg-blue-50 px-4 py-1.5 rounded-full">Việc
                            làm mới nhất</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3">Việc làm được chọn riêng cho bạn</h2>
                        <p class="text-gray-500 mt-2">Những vị trí hot nhất từ các công ty hàng đầu</p>
                    </div>
                    <a href="{{ route('candidate.jobs.index') }}"
                        class="text-blue-600 font-medium hover:underline flex items-center gap-1 mt-2 sm:mt-0">
                        Xem tất cả
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($featuredJobs as $job)
                        <div
                            class="group bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 line-clamp-2">{{ $job->title }}</h3>
                                    <div class="flex items-center gap-1 text-gray-500 text-sm mt-1">
                                        <span class="material-symbols-outlined text-base">business</span>
                                        <span>{{ $job->company->company_name ?? 'Công ty' }}</span>
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ $job->employment_type ?? 'Toàn thời gian' }}
                                </span>
                            </div>
                            <div class="mt-4 flex items-center gap-2 text-gray-600 text-sm flex-wrap">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-base">payments</span>
                                    {{ $job->salary_range ?? 'Thỏa thuận' }}
                                </span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-base">location_on</span>
                                    {{ $job->location ?? 'Linh hoạt' }}
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm mt-3 line-clamp-2">{{ Str::limit($job->description, 80) }}</p>
                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach($job->skills->take(3) as $skill)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            <div class="mt-5">
                                <a href="{{ route('candidate.jobs.show', $job->slug ?? $job->id) }}"
                                    class="block w-full text-center text-blue-600 font-medium hover:bg-blue-50 px-4 py-2.5 rounded-xl transition border border-blue-200 group-hover:bg-blue-50">
                                    Ứng tuyển →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center py-12">
                            <span class="material-symbols-outlined text-5xl text-gray-300">work_off</span>
                            <p class="text-gray-400 mt-3">Chưa có tin tuyển dụng nào</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-12 text-center">
                <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 md:p-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Sẵn sàng nâng tầm sự nghiệp?</h2>
                    <p class="text-blue-100 text-lg mb-8">Hàng ngàn cơ hội việc làm đang chờ bạn. Tải CV ngay hôm nay!</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('candidate.cv.index') }}"
                            class="px-8 py-3.5 bg-white text-blue-600 font-semibold rounded-xl hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">upload</span>
                            Tải CV lên ngay
                        </a>
                        <a href="{{ route('candidate.companies') }}"
                            class="px-8 py-3.5 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">business</span>
                            Xem danh sách công ty
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes blob {

            0%,
            100% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection