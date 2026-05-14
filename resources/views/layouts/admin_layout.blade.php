<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Admin Console - Executive Curator')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#004ac6",
                        "primary-dark": "#003ea8",
                        accent: "#2563eb",
                        surface: "#f8f9ff",
                        onSurface: "#121c28",
                        onSurfaceVariant: "#434655",
                    },
                    fontFamily: {
                        headline: ["Manrope", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    },
                },
            },
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9ff;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
        }

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

<body class="bg-gradient-to-br from-gray-50 to-blue-50/30 antialiased">

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed left-0 top-0 h-full w-72 bg-white shadow-2xl border-r border-gray-100 flex flex-col z-50 transition-all duration-300 -translate-x-full lg:translate-x-0">

        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg">
                    <span class="material-symbols-outlined text-white text-2xl">admin_panel_settings</span>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-gray-900 leading-tight font-headline">Admin Console</h2>
                    <p class="text-xs text-gray-400 font-medium">System Oversight</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:translate-x-1' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-medium text-sm">Dashboard</span>
                @if(request()->routeIs('admin.dashboard'))
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                @endif
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:translate-x-1">
                <span class="material-symbols-outlined">group</span>
                <span class="font-medium text-sm">Quản lý người dùng</span>
            </a>

            <a href="{{ route('admin.jobs.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:translate-x-1">
                <span class="material-symbols-outlined">work</span>
                <span class="font-medium text-sm">Quản lý tin tuyển dụng</span>
            </a>

            <a href="{{ route('admin.logs.ai_matching') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:translate-x-1">
                <span class="material-symbols-outlined">terminal</span>
                <span class="font-medium text-sm">AI Audit Logs</span>
            </a>

            <a href="{{ route('admin.skills.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:translate-x-1">
                <span class="material-symbols-outlined">psychology</span>
                <span class="font-medium text-sm">
                    Quản lý kỹ năng
                </span>
            </a>

            <a href="{{ route('admin.languages.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:translate-x-1">
                <span class="material-symbols-outlined">language</span>
                <span class="font-medium text-sm">
                    Quản lý ngôn ngữ
                </span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100 space-y-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-500 hover:bg-red-50 transition-all group">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-medium text-sm">Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleMobileMenu()">
    </div>

    <!-- Main Content -->
    <main class="lg:ml-72 min-h-screen">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
            <div class="px-6 py-4 flex items-center justify-between">
                <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="flex items-center gap-4 ml-auto">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold shadow-md text-sm">
                            AD
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-700">Administrator</p>
                            <p class="text-xs text-gray-400">Super Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileMenuOverlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar')?.classList.remove('-translate-x-full');
                document.getElementById('mobileMenuOverlay')?.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>