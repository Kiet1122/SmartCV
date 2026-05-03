<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport" />
    <title>@yield('title', 'SmartCV - Ứng viên')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#004ac6",
                        "primary-container": "#2563eb",
                        "surface": "#f8f9ff",
                        "surface-container-low": "#eef4ff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#121c28",
                        "on-surface-variant": "#434655",
                        "outline-variant": "#c3c6d7",
                        "secondary-container": "#acbfff",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"],
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Sidebar styles */
        .sidebar-item {
            transition: all 0.2s ease;
            position: relative;
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, #004ac6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 74, 198, 0.2);
        }

        .sidebar-item.active i {
            color: white;
        }

        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 70%;
            background: white;
            border-radius: 0 3px 3px 0;
        }

        .sidebar-item:hover:not(.active) {
            background: #eef4ff;
            color: #004ac6;
        }

        .sidebar-item:hover:not(.active) i {
            color: #004ac6;
        }

        /* Mobile menu styles */
        .mobile-menu {
            transition: transform 0.3s ease-in-out;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-surface font-body text-on-surface antialiased">
    <!-- TopNavBar -->
    <header
        class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-xl shadow-sm flex justify-between items-center px-4 md:px-6 h-16">
        <!-- Logo -->
        <div class="flex items-center gap-2 md:gap-4">
            <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-primary transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <i class="fas fa-brain text-blue-600 text-2xl"></i>
                <span
                    class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-indigo-600 bg-clip-text text-transparent">
                    SmartCV
                </span>
            </a>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center gap-2 md:gap-4">
            <!-- Search -->
            <div class="hidden md:block relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    class="bg-gray-50 border border-gray-200 rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all w-64"
                    placeholder="Tìm kiếm việc làm..." type="text" />
            </div>

            <!-- Notification -->
            <button class="relative text-gray-600 hover:text-primary transition-colors">
                <i class="fas fa-bell text-xl"></i>
                <span
                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center">3</span>
            </button>

            <!-- User Avatar Dropdown -->
            <div class="relative group">
                <div
                    class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm cursor-pointer">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>

                <div
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="py-2">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Người dùng' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'user@smartcv.ai' }}</p>
                        </div>
                        <a href="{{ route('candidate.profile') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 transition">
                            <i class="fas fa-user-circle w-5 text-blue-500"></i>
                            <span class="text-sm">Hồ sơ của tôi</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-blue-50 transition">
                            <i class="fas fa-cog w-5 text-blue-500"></i>
                            <span class="text-sm">Cài đặt</span>
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition text-left">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                <span class="text-sm">Đăng xuất</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar + Main Content Layout -->
    <div class="flex pt-16 min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:relative z-40 w-64 bg-white border-r border-gray-200 h-full transition-transform duration-300 transform -translate-x-full lg:translate-x-0 shadow-lg lg:shadow-none">
            <div class="flex flex-col h-full">
                <!-- User Info -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">
                                {{ Auth::user()->name ?? 'Người dùng' }}
                            </p>
                            <p class="text-xs text-gray-500">Ứng viên</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 py-4 overflow-y-auto">
                    <div class="px-3 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('candidate.dashboard') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 {{ request()->routeIs('candidate.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line w-5"></i>
                            <span class="text-sm font-medium">Tổng quan</span>
                        </a>

                        <!-- CV Management -->
                        <a href="{{ route('candidate.cv.index') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 {{ request()->routeIs('candidate.cv.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt w-5"></i>
                            <span class="text-sm font-medium">Quản lý CV</span>
                        </a>

                        <!-- AI Review -->
                        <a href="{{ route('candidate.ai_review.index') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 {{ request()->routeIs('candidate.ai_review.*') ? 'active' : '' }}">
                            <i class="fas fa-robot w-5"></i>
                            <span class="text-sm font-medium">Đánh giá AI</span>
                        </a>

                        <!-- Applications -->
                        <a href="{{ route('candidate.applications.index') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                            {{ request()->routeIs('candidate.applications.index') ? 'active bg-indigo-50 text-indigo-600 font-bold' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-paper-plane w-5"></i>
                            <span class="text-sm font-medium">Đơn ứng tuyển</span>
                        </a>

                        <!-- Job Recommendations -->
                        <a href="{{ route('candidate.applications.recommendations') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 transition-colors {{ request()->routeIs('candidate.applications.recommendations') ? 'active bg-indigo-50 text-indigo-600 font-bold' : 'hover:bg-gray-100' }}">
                            <i
                                class="fas fa-magic w-5 {{ request()->routeIs('candidate.applications.recommendations') ? 'text-indigo-600' : 'text-amber-500' }}"></i>
                            <span class="text-sm font-medium">Việc làm AI gợi ý</span>
                        </a>

                        <!-- Saved Jobs -->
                        <a href="{{ route('candidate.saved_jobs') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700">
                            <i class="fas fa-bookmark w-5"></i>
                            <span class="text-sm font-medium">Việc làm đã lưu</span>
                        </a>

                        <!-- Divider -->
                        <div class="my-3 border-t border-gray-200"></div>

                        <!-- Profile -->
                        <a href="{{ route('candidate.profile') }}"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700">
                            <i class="fas fa-user-circle w-5"></i>
                            <span class="text-sm font-medium">Hồ sơ cá nhân</span>
                        </a>
                    </div>
                </nav>

                <!-- Logout Button (Mobile) -->
                <div class="p-4 border-t border-gray-200 lg:hidden">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="text-sm font-medium">Đăng xuất</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" style="top: 64px;"></div>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 bg-gray-50">
            <div class="p-4 md:p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('translate-x-0');
            if (isOpen) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                sidebarOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on window resize if open
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                if (sidebar.classList.contains('translate-x-0')) {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        });

        // Active menu highlighting
        document.querySelectorAll('.sidebar-item').forEach(item => {
            if (item.href === window.location.href) {
                item.classList.add('active');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>