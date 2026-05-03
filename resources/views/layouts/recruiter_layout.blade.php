<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'The Curator | Executive Recruitment Atelier')</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (nếu cần) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom config for Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#004ac6',
                        'primary-dark': '#003ea8',
                        secondary: '#495c95',
                        surface: '#f8f9ff',
                        'surface-container': '#e5eeff',
                        'surface-container-low': '#eef4ff',
                        'surface-container-high': '#dfe9fa',
                        'surface-container-lowest': '#ffffff',
                        'on-surface': '#121c28',
                        'on-surface-variant': '#434655',
                    },
                    fontFamily: {
                        headline: ['Manrope', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    borderRadius: {
                        'xl': '0.75rem',
                        '2xl': '1rem',
                    }
                }
            }
        }
    </script>

    @stack('styles')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        .headline-font {
            font-family: 'Manrope', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .bg-primary-gradient {
            background: linear-gradient(135deg, #004ac6 0%, #2563eb 100%);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>

<body class="bg-surface text-on-surface">

    @php
        $user = session('user') ?? auth()->user();
        $company = null;

        if ($user && $user->role === 'recruiter' && $user->company_id) {
            $company = \App\Models\Company::find($user->company_id);
        }

        $companyName = $company ? $company->company_name : 'The Curator';
        $companySlogan = $company ? ($company->slogan ?? 'Executive Recruitment Atelier') : 'Executive Recruitment Atelier';
        $userInitial = $user ? strtoupper(substr($user->name, 0, 2)) : 'JD';
    @endphp

    <!-- Sidebar -->
    <aside
        class="fixed left-0 top-0 h-full w-72 bg-white/95 backdrop-blur-sm border-r border-gray-200 flex flex-col z-50 shadow-xl">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-primary-gradient rounded-xl flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-white text-2xl">auto_awesome</span>
                </div>
                <div>
                    <span class="text-xl font-bold text-gray-800 tracking-tight">{{ $companyName }}</span>
                    <p class="text-[10px] uppercase tracking-wider text-gray-400 mt-0.5">{{ $companySlogan }}</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1.5">
            <a href="{{ route('recruiter.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('recruiter.dashboard') ? 'text-blue-600 bg-blue-50 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Tổng quan</span>
            </a>
            <a href="{{ route('recruiter.jobs.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('recruiter.jobs*') ? 'text-blue-600 bg-blue-50 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">work</span>
                <span>Quản lý tin tuyển dụng</span>
            </a>
            <a href="{{ route('recruiter.applicants.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('recruiter.candidates*') ? 'text-blue-600 bg-blue-50 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">group</span>
                <span>Ứng viên</span>
            </a>
            <a href="{{ route('recruiter.reports.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('recruiter.reports*') ? 'text-blue-600 bg-blue-50 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Báo cáo & Phân tích</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100 space-y-2">
            @if($company && isset($company->is_verified) && $company->is_verified)
                <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 rounded-xl mb-2">
                    <span class="material-symbols-outlined text-emerald-600 text-sm"
                        style="font-variation-settings: 'FILL' 1;">verified</span>
                    <span class="text-xs text-emerald-700 font-medium">Công ty đã xác thực</span>
                </div>
            @endif

            <a href="{{-- route('recruiter.settings') --}}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition-all">
                <span class="material-symbols-outlined">settings</span>
                <span>Cài đặt</span>
            </a>
            <a href="{{-- route('recruiter.support') --}}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-500 hover:bg-gray-50 transition-all">
                <span class="material-symbols-outlined">help</span>
                <span>Trợ giúp</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-500 hover:bg-red-50 transition-all">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Header -->
    <header
        class="fixed top-0 right-0 left-72 h-16 bg-white/80 backdrop-blur-md border-b border-gray-100 z-40 flex items-center justify-between px-8">
        <div class="relative w-96">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
            <input type="text" placeholder="Tìm kiếm ứng viên, công việc..."
                class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
        </div>

        <div class="flex items-center gap-4">
            <button class="p-2 rounded-full hover:bg-gray-100 transition-all relative">
                <span class="material-symbols-outlined text-gray-500">notifications</span>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <button class="p-2 rounded-full hover:bg-gray-100 transition-all">
                <span class="material-symbols-outlined text-gray-500">chat</span>
            </button>
            <div class="w-px h-6 bg-gray-200"></div>
            <a href="{{-- route('recruiter.jobs.create') --}}"
                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">add</span>
                Đăng tin mới
            </a>

            <!-- User Menu Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold shadow-md">
                        {{ $userInitial }}
                    </div>
                    <span class="hidden md:inline text-sm text-gray-700">{{ $user ? $user->name : 'Recruiter' }}</span>
                    <span class="material-symbols-outlined text-gray-400 text-sm">expand_more</span>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-900">{{ $user ? $user->name : 'Recruiter' }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $user ? $user->email : '' }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('recruiter.profile') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <span class="material-symbols-outlined text-gray-400 text-base">account_circle</span>
                            <span>Hồ sơ của tôi</span>
                        </a>
                        <a href="{{-- route('recruiter.settings') --}}"
                            class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <span class="material-symbols-outlined text-gray-400 text-base">settings</span>
                            <span>Cài đặt</span>
                        </a>
                        @if($company)
                            <a href="{{ route('recruiter.company.profile') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-gray-400 text-base">business</span>
                                <span>Thông tin công ty</span>
                            </a>
                        @endif
                    </div>
                    <div class="border-t border-gray-100 pt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined text-red-500 text-base">logout</span>
                                <span>Đăng xuất</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-72 pt-20 pb-8 px-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>