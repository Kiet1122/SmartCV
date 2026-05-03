<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>SmartCV | AI-Powered Recruitment Platform</title>
    <!-- Tailwind CSS + Font Awesome + Google Fonts (Inter) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">
    <!-- Google Material Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <!-- custom override for smooth shadows and refined rounding -->
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: #f9fafc;
            scroll-behavior: smooth;
        }

        .shadow-soft {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.03), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }

        .card-hover {
            transition: all 0.25s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
        }

        .btn-transition {
            transition: all 0.2s ease;
        }

        .job-card {
            transition: all 0.25s;
        }

        .job-card:hover {
            border-color: #e2e8f0;
            background-color: white;
            box-shadow: 0 12px 20px -12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .sticky-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.92);
        }

        .hero-bg-gradient {
            background: radial-gradient(ellipse at 70% 30%, rgba(37, 99, 235, 0.03), transparent 70%);
        }

        .step-circle {
            transition: all 0.2s;
        }

        .group:hover .step-circle {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
            transform: scale(1.02);
        }

        @media (max-width: 768px) {
            .hero-padding {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }
    </style>
</head>

<body class="antialiased">

    <!-- ========== HEADER / NAVBAR (STICKY) ========== -->
    <header
        class="sticky top-0 z-50 w-full bg-white/90 backdrop-blur-md border-b border-gray-200/70 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="flex justify-between items-center py-4 md:py-5">
                <!-- Logo -->
                <div class="flex items-center space-x-2 cursor-pointer" onclick="window.location='{{ route('home') }}'">
                    <i class="fas fa-brain text-blue-600 text-2xl"></i>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-indigo-600 bg-clip-text text-transparent">SmartCV</span>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-8 text-gray-700 font-medium">

                    <a href="{{ route('public.home') }}" class="hover:text-blue-600 transition">
                        Trang chủ
                    </a>

                    <a href="{{ route('candidate.jobs.index') }}" class="hover:text-blue-600 transition">
                        Công việc
                    </a>

                    <a href="{{ route('candidate.companies') }}" class="hover:text-blue-600 transition">
                        Danh sách công ty
                    </a>

                    <div>
                        <div class="flex items-center space-x-3 ml-2">
                            @auth
                                <!-- Hiển thị khi đã đăng nhập -->
                                <div class="relative group">
                                    <button
                                        class="flex items-center gap-2 px-4 py-2 text-gray-700 font-semibold hover:bg-gray-100 rounded-xl transition-all duration-200">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                        <i
                                            class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200 group-hover:rotate-180"></i>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                        <div class="py-1">
                                            <!-- Dashboard -->
                                            <a href="@if(Auth::user()->role == 'admin') {{ route('admin.dashboard') }} 
                                               @elseif(Auth::user()->role == 'recruiter') {{ route('recruiter.dashboard') }} 
                                                   @else {{ route('candidate.dashboard') }} @endif"
                                                class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 transition">
                                                <i class="fas fa-tachometer-alt w-4 text-blue-500"></i>
                                                <span>Dashboard</span>
                                            </a>

                                            <!-- Divider -->
                                            <div class="border-t border-gray-100 my-1"></div>

                                            <!-- Logout -->
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition text-left">
                                                    <i class="fas fa-sign-out-alt w-4"></i>
                                                    <span>Đăng xuất</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endauth

                            @guest
                                <a href="{{ route('login') }}"
                                    class="px-4 py-2 text-blue-600 font-semibold hover:bg-blue-50 rounded-xl transition">
                                    Đăng nhập
                                </a>

                                <a href="{{ route('register') }}"
                                    class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 transition shadow-md">
                                    Đăng ký
                                </a>
                            @endguest
                        </div>

                        <style>
                            .group:hover .group-hover\:visible {
                                visibility: visible !important;
                            }

                            .group:hover .group-hover\:opacity-100 {
                                opacity: 100 !important;
                            }

                            .fa-chevron-down {
                                transition: transform 0.2s ease;
                            }

                            .group:hover .fa-chevron-down {
                                transform: rotate(180deg);
                            }
                        </style>
                    </div>

                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 focus:outline-none" aria-label="menu">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                <!-- Thương hiệu -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-brain text-blue-400 text-2xl"></i>
                        <span class="text-xl font-bold text-white">SmartCV</span>
                    </div>
                    <p class="text-sm text-gray-400">
                        Nền tảng tuyển dụng ứng dụng AI, kết nối ứng viên và doanh nghiệp một cách thông minh và hiệu
                        quả.
                    </p>
                    <div class="flex gap-4 mt-5">
                        <a href="#"
                            class="hover:text-white transition text-gray-400 hover:bg-gray-800 p-2 rounded-full">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="#"
                            class="hover:text-white transition text-gray-400 hover:bg-gray-800 p-2 rounded-full">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#"
                            class="hover:text-white transition text-gray-400 hover:bg-gray-800 p-2 rounded-full">
                            <i class="fab fa-github text-lg"></i>
                        </a>
                        <a href="#"
                            class="hover:text-white transition text-gray-400 hover:bg-gray-800 p-2 rounded-full">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Giới thiệu -->
                <div>
                    <h4 class="font-semibold text-white text-lg mb-4">Giới thiệu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('public.about') }}" class="hover:text-blue-400 transition">Về chúng
                                tôi</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Tuyển dụng</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Báo chí</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Blog</a></li>
                    </ul>
                </div>

                <!-- Liên hệ -->
                <div>
                    <h4 class="font-semibold text-white text-lg mb-4">Liên hệ</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('public.contact') }}" class="hover:text-blue-400 transition">Trung tâm trợ
                                giúp</a></li>
                        <li><a href="{{ route('public.contact') }}" class="hover:text-blue-400 transition">Hỗ trợ</a>
                        </li>
                        <li><a href="{{ route('public.contact') }}" class="hover:text-blue-400 transition">Liên hệ kinh
                                doanh</a></li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <i class="fas fa-envelope"></i> hello@smartcv.ai
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <i class="fas fa-phone"></i> +1 (555) 123-4567
                        </li>
                    </ul>
                </div>

                <!-- Pháp lý -->
                <div>
                    <h4 class="font-semibold text-white text-lg mb-4">Pháp lý</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition">Chính sách bảo mật</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Điều khoản sử dụng</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Tùy chọn cookie</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition">Bảo vệ dữ liệu</a></li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
                © 2025 SmartCV — Nền tảng tuyển dụng AI. Bảo lưu mọi quyền.
            </div>
        </div>
    </footer>
</body>

</html>