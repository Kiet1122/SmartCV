@extends('layouts.master')

@section('title', $company->company_name . ' | SmartCV - Nhà tuyển dụng hàng đầu')

@section('content')
    <main>
        <!-- Company Header Section -->
        <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-12 md:py-16">

                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-blue-100 mb-6">
                    <a href="{{ route('public.home') }}" class="hover:text-white transition">Trang chủ</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="{{ route('candidate.companies') }}" class="hover:text-white transition">Công ty</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-white">{{ $company->company_name }}</span>
                </div>

                <!-- Company Info -->
                <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
                    <!-- Logo -->
                    <div class="w-28 h-28 rounded-2xl bg-white shadow-lg flex items-center justify-center overflow-hidden">
                        @if($company->logo_url)
                            <img src="{{ asset('storage/' . $company->logo_url) }}" alt="{{ $company->company_name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                <i class="fas fa-building text-4xl text-blue-500"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-center md:text-left text-white">
                        <div class="flex flex-wrap items-center gap-3 justify-center md:justify-start mb-2">
                            <h1 class="text-3xl md:text-4xl font-bold">{{ $company->company_name }}</h1>
                        </div>
                        <div class="flex flex-wrap gap-4 justify-center md:justify-start text-blue-100">
                            @if($company->address)
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt"></i> {{ $company->address }}
                                </span>
                            @endif
                            @if($company->website)
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-globe"></i>
                                    <a href="{{ $company->website }}" target="_blank"
                                        class="hover:text-white transition">{{ $company->website }}</a>
                                </span>
                            @endif
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt"></i> Tham gia: {{ $company->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Left Column - Company Details -->
                    <div class="lg:col-span-1">
                        <!-- About Company -->
                        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                Giới thiệu công ty
                            </h3>
                            <div class="text-gray-600 leading-relaxed space-y-3">
                                <p>{{ $company->description ?? 'Chưa có thông tin mô tả. Công ty đang trong quá trình cập nhật thông tin.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Company Info -->
                        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-building text-blue-500"></i>
                                Thông tin công ty
                            </h3>
                            <div class="space-y-3 text-gray-600">
                                {{-- Ngành nghề --}}
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-tag text-blue-500 w-5"></i>
                                    <span>{{ $company->industry ?? 'Chưa cập nhật' }}</span>
                                </div>

                                {{-- Quy mô --}}
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-users text-blue-500 w-5"></i>
                                    <span>{{ $company->company_size ? number_format($company->company_size) . ' nhân sự' : 'Chưa cập nhật' }}</span>
                                </div>

                                {{-- Email --}}
                                @if($company->email)
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-envelope text-blue-500 w-5"></i>
                                        <a href="mailto:{{ $company->email }}"
                                            class="hover:text-blue-600">{{ $company->email }}</a>
                                    </div>
                                @endif

                                {{-- Website --}}
                                @if($company->website)
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-globe text-blue-500 w-5"></i>
                                        <a href="{{ $company->website }}" target="_blank"
                                            class="hover:text-blue-600">{{ $company->website }}</a>
                                    </div>
                                @endif

                                {{-- Địa chỉ --}}
                                @if($company->address)
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-map-marker-alt text-blue-500 w-5"></i>
                                        <span>{{ $company->address }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Social Links (nếu có) -->
                        @if($company->facebook || $company->linkedin || $company->zalo)
                            <div class="bg-white rounded-2xl shadow-sm p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-share-alt text-blue-500"></i>
                                    Mạng xã hội
                                </h3>
                                <div class="flex gap-3">
                                    @if($company->facebook)
                                        <a href="{{ $company->facebook }}" target="_blank"
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-500 hover:text-white transition">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif
                                    @if($company->linkedin)
                                        <a href="{{ $company->linkedin }}" target="_blank"
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-500 hover:text-white transition">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    @endif
                                    @if($company->zalo)
                                        <a href="{{ $company->zalo }}" target="_blank"
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-500 hover:text-white transition">
                                            <i class="fab fa-zalo"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column - Job Listings -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex flex-wrap justify-between items-center gap-3">
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-800">
                                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>
                                            Tin tuyển dụng ({{ $stats['active_jobs'] }})
                                        </h2>
                                        <p class="text-gray-500 text-sm mt-1">Cơ hội việc làm hấp dẫn đang chờ đón bạn</p>
                                    </div>
                                    <div class="relative">
                                        <i
                                            class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="text" id="searchJob" placeholder="Tìm kiếm việc làm..."
                                            class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                    </div>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-100" id="jobsList">
                                @forelse($jobs as $job)
                                    <div class="p-6 hover:bg-gray-50 transition job-item"
                                        data-title="{{ strtolower($job->title) }}">
                                        <div class="flex flex-wrap items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-800 hover:text-blue-600 transition">
                                                    <a href="{{ route('candidate.jobs.show', $job->id) }}">{{ $job->title }}</a>
                                                </h3>
                                                <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-500">
                                                    <span class="flex items-center gap-1">
                                                        <i class="fas fa-dollar-sign"></i>
                                                        {{ $job->salary_range ?? 'Thỏa thuận' }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        {{ $job->location ?? 'Linh hoạt' }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <i class="fas fa-clock"></i>
                                                        {{ $job->employment_type ?? 'Toàn thời gian' }}
                                                    </span>
                                                </div>
                                                <p class="text-gray-500 text-sm mt-3 line-clamp-2">
                                                    {{ Str::limit($job->description ?? '', 100) }}
                                                </p>
                                                <div class="flex flex-wrap gap-2 mt-3">
                                                    @foreach($job->skills->take(3) as $skill)
                                                        <span
                                                            class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $skill->name }}</span>
                                                    @endforeach
                                                    @if($job->skills->count() > 3)
                                                        <span
                                                            class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">+{{ $job->skills->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <a href="{{ route('candidate.jobs.show', $job->id) }}"
                                                    class="inline-block mt-3 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium hover:bg-blue-100 transition">
                                                    Ứng tuyển →
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-12 text-center">
                                        <div
                                            class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-briefcase text-3xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Chưa có tin tuyển dụng</h3>
                                        <p class="text-gray-500">Hiện tại công ty chưa có tin tuyển dụng nào</p>
                                    </div>
                                @endforelse
                            </div>

                            @if($jobs->hasPages())
                                <div class="p-6 border-t border-gray-100">
                                    {{ $jobs->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Similar Companies -->
        @php
            $similarCompanies = \App\Models\Company::where('id', '!=', $company->id)
                ->when($company->industry, function ($q) use ($company) {
                    $q->where('industry', $company->industry);
                })
                ->withCount([
                    'jobPosts' => function ($q) {
                        $q->where('status', 'open');
                    }
                ])
                ->take(4)
                ->get();
        @endphp

        @if($similarCompanies->count() > 0)
            <section class="py-12 bg-white">
                <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-building text-blue-500"></i>
                            Công ty tương tự
                        </h2>
                        <a href="{{ route('candidate.companies') }}"
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($similarCompanies as $similar)
                            <a href="{{ route('candidate.companies.show', $similar->id) }}"
                                class="group block bg-gray-50 rounded-xl p-4 hover:shadow-md transition-all">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center overflow-hidden">
                                        @if($similar->logo_url)
                                            <img src="{{ asset('storage/' . $similar->logo_url) }}" alt="{{ $similar->company_name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-building text-blue-500 text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition">
                                            {{ $similar->company_name }}
                                        </h4>
                                        <p class="text-xs text-gray-500">{{ $similar->job_posts_count }} việc làm</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        // Search job in company
        const searchInput = document.getElementById('searchJob');
        const jobItems = document.querySelectorAll('.job-item');

        searchInput?.addEventListener('keyup', function () {
            const searchTerm = this.value.toLowerCase();
            jobItems.forEach(item => {
                const title = item.dataset.title || '';
                if (title.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection