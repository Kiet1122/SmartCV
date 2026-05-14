@extends('layouts.recruiter_layout')

@section('title', 'Bảng điều khiển | The Curator')

@section('content')
    <!-- Header chào mừng -->
    <section class="mb-8 pt-4 animate-fadeIn">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Chào mừng trở lại, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-500">
                    Quản lý tuyển dụng tại <span class="font-semibold text-blue-600">{{ $company->company_name }}</span>
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('recruiter.jobs.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-base">add</span>
                    Đăng tin mới
                </a>
                <button onclick="location.reload()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    Làm mới
                </button>
            </div>
        </div>
    </section>

    <!-- Hàng thẻ thống kê -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Thẻ tin tuyển dụng đang hoạt động -->
        <div
            class="stat-card group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 group-hover:bg-blue-100 transition-colors flex items-center justify-center">
                    <span
                        class="material-symbols-outlined text-blue-600 group-hover:scale-110 transition-transform">work</span>
                </div>
                <span
                    class="text-blue-600 text-xs font-semibold bg-blue-50 group-hover:bg-blue-100 px-2.5 py-1 rounded-full transition-colors">Đang
                    hoạt động</span>
            </div>
            <h3 class="text-sm text-gray-500 mb-1">Tin tuyển dụng đang hoạt động</h3>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['active_jobs'] }}</div>
        </div>

        <!-- Thẻ tổng số ứng viên -->
        <div
            class="stat-card group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 group-hover:bg-emerald-100 transition-colors flex items-center justify-center">
                    <span
                        class="material-symbols-outlined text-emerald-600 group-hover:scale-110 transition-transform">group</span>
                </div>
                <span
                    class="text-emerald-600 text-xs font-semibold bg-emerald-50 group-hover:bg-emerald-100 px-2.5 py-1 rounded-full transition-colors">
                    {{ $stats['applicant_growth'] >= 0 ? '+' : '' }}{{ $stats['applicant_growth'] }}%
                </span>
            </div>
            <h3 class="text-sm text-gray-500 mb-1">Tổng số ứng viên</h3>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_applicants']) }}</div>
        </div>

        <!-- Thẻ đã sàng lọc bằng AI -->
        <div
            class="stat-card group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-amber-200 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 group-hover:bg-amber-100 transition-colors flex items-center justify-center">
                    <span
                        class="material-symbols-outlined text-amber-600 group-hover:scale-110 transition-transform">psychology</span>
                </div>
                <span
                    class="text-amber-600 text-xs font-semibold bg-amber-50 group-hover:bg-amber-100 px-2.5 py-1 rounded-full transition-colors">AI
                    Sàng lọc</span>
            </div>
            <h3 class="text-sm text-gray-500 mb-1">Đã sàng lọc bằng AI</h3>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['ai_screened']) }}</div>
            <p class="text-xs text-gray-400 mt-1">Điểm TB: {{ number_format($avgAIScore ?? 0, 1) }}/100</p>
        </div>

        <!-- Thẻ ứng viên tiềm năng -->
        <div
            class="stat-card group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 group-hover:bg-purple-100 transition-colors flex items-center justify-center">
                    <span
                        class="material-symbols-outlined text-purple-600 group-hover:scale-110 transition-transform">star</span>
                </div>
                <span
                    class="text-purple-600 text-xs font-semibold bg-purple-50 group-hover:bg-purple-100 px-2.5 py-1 rounded-full transition-colors">Tiềm
                    năng</span>
            </div>
            <h3 class="text-sm text-gray-500 mb-1">Ứng viên tiềm năng</h3>
            <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['shortlisted']) }}</div>
        </div>
    </div>

    <!-- Hàng biểu đồ & thống kê nhanh -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Phần biểu đồ -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Tổng quan ứng viên</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        <span id="chartPeriodLabel">
                            @if($chartType === 'week')
                                Tuần này ({{ Carbon\Carbon::now()->startOfWeek()->format('d/m') }} -
                                {{ Carbon\Carbon::now()->endOfWeek()->format('d/m') }})
                            @else
                                Năm {{ Carbon\Carbon::now()->year }}
                            @endif
                        </span>
                    </p>
                </div>
                <div class="flex gap-2">
                    <button onclick="switchChart('week')" id="btnWeek"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg transition-all {{ $chartType === 'week' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Tuần
                    </button>
                    <button onclick="switchChart('month')" id="btnMonth"
                        class="px-3 py-1.5 text-xs font-medium rounded-lg transition-all {{ $chartType === 'month' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Tháng
                    </button>
                </div>
            </div>

            <!-- Container biểu đồ cột -->
            <div id="chartContainer">
                <div class="h-64 flex items-end justify-between gap-3" id="chartBars">
                    @if($chartType === 'week')
                        @foreach($chartData as $item)
                            <div class="w-full flex flex-col items-center gap-2 group">
                                <div class="w-full bg-gradient-to-t from-gray-100 to-gray-50 rounded-t-lg transition-all duration-300 group-hover:from-blue-100 group-hover:to-blue-50 relative cursor-pointer"
                                    style="height: {{ max($item['height'], 5) }}%">
                                    <div
                                        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg">
                                        {{ $item['count'] }} ứng viên
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-gray-500">{{ $item['day'] }}</span>
                                <span class="text-xs text-gray-400">{{ $item['label'] }}</span>
                            </div>
                        @endforeach
                    @else
                        @foreach($chartData as $item)
                            <div class="w-full flex flex-col items-center gap-2 group">
                                <div class="w-full bg-gradient-to-t from-gray-100 to-gray-50 rounded-t-lg transition-all duration-300 group-hover:from-blue-100 group-hover:to-blue-50 relative cursor-pointer"
                                    style="height: {{ max($item['height'], 5) }}%">
                                    <div
                                        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg">
                                        {{ $item['count'] }} ứng viên
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-gray-500">{{ $item['month'] }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Loading Spinner -->
            <div id="chartLoading" class="hidden h-64 flex items-center justify-center">
                <div class="text-center">
                    <div class="inline-block w-8 h-8 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin">
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Đang tải dữ liệu...</p>
                </div>
            </div>

            <!-- Chú thích biểu đồ -->
            <div class="flex justify-center gap-4 mt-6 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-xs text-gray-500">Số lượng ứng viên</span>
                </div>
            </div>
        </div>

        <!-- Bảng thống kê nhanh -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Thống kê nhanh</h2>
                <span class="text-xs text-gray-400">Cập nhật hôm nay</span>
            </div>
            <div class="space-y-4">
                <div
                    class="group flex justify-between items-center pb-3 border-b border-gray-100 hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                    <span class="text-gray-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Chờ xét duyệt
                    </span>
                    <span class="font-bold text-amber-600 text-lg">{{ number_format($stats['pending_review']) }}</span>
                </div>
                <div
                    class="group flex justify-between items-center pb-3 border-b border-gray-100 hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                    <span class="text-gray-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Đã chọn phỏng vấn
                    </span>
                    <span class="font-bold text-emerald-600 text-lg">{{ number_format($stats['shortlisted']) }}</span>
                </div>
                <div
                    class="group flex justify-between items-center pb-3 border-b border-gray-100 hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                    <span class="text-gray-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        Đã từ chối
                    </span>
                    <span class="font-bold text-red-500 text-lg">{{ number_format($stats['rejected']) }}</span>
                </div>
                <div
                    class="group flex justify-between items-center pb-3 border-b border-gray-100 hover:bg-gray-50 -mx-2 px-2 rounded-lg transition-colors">
                    <span class="text-gray-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Đã tuyển
                    </span>
                    <span class="font-bold text-blue-600 text-lg">{{ number_format($stats['hired']) }}</span>
                </div>
                <div class="flex justify-between items-center pt-3">
                    <span class="font-semibold text-gray-700">Tỉ lệ chọn</span>
                    <div class="text-right">
                        <span class="font-bold text-blue-600 text-xl">
                            {{ $stats['total_applicants'] > 0 ? round(($stats['shortlisted'] / $stats['total_applicants']) * 100) : 0 }}%
                        </span>
                        <div class="w-24 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full"
                                style="width: {{ $stats['total_applicants'] > 0 ? ($stats['shortlisted'] / $stats['total_applicants']) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng tin tuyển dụng đang hoạt động -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-100 flex-wrap gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Tin tuyển dụng đang hoạt động</h2>
                <p class="text-gray-500 text-sm mt-0.5">Quản lý và theo dõi các vị trí đang tuyển dụng</p>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                    <input type="text" id="searchJob" placeholder="Tìm kiếm..."
                        class="pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-xl w-48 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                </div>
                <a href="{{ route('recruiter.jobs.create') }}"
                    class="text-blue-600 text-sm font-semibold hover:underline flex items-center gap-1 bg-blue-50 px-3 py-2 rounded-xl">
                    <span class="material-symbols-outlined text-base">add</span>
                    Đăng tin mới
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full" id="jobsTable">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Vị trí</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Lượt xem</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Ứng viên</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Điểm TB</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($activeJobList as $job)
                        <tr class="hover:bg-gray-50/50 transition-colors job-row"
                            data-job-title="{{ strtolower($job->title) }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-700 font-bold text-sm">
                                        {{ strtoupper(substr($job->title, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $job->title }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">
                                            {{ $job->experience_required ?? 'Không yêu cầu' }} năm KN
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-gray-400 text-sm">visibility</span>
                                    {{ number_format($job->views ?? 0) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center justify-center px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-semibold">
                                    {{ number_format($job->applications_count) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php $avgScore = $job->applications()->avg('match_score'); @endphp
                                @if($avgScore)
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-amber-500 text-sm">star</span>
                                        <span class="font-medium">{{ number_format($avgScore, 1) }}/100</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Chưa có</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'open' => ['class' => 'bg-emerald-100 text-emerald-700', 'dot' => 'bg-emerald-500', 'text' => 'Đang tuyển'],
                                        'pending' => ['class' => 'bg-amber-100 text-amber-700', 'dot' => 'bg-amber-500', 'text' => 'Chờ duyệt'],
                                        'closed' => ['class' => 'bg-gray-100 text-gray-700', 'dot' => 'bg-gray-500', 'text' => 'Đã đóng'],
                                        'rejected' => ['class' => 'bg-rose-100 text-rose-700', 'dot' => 'bg-rose-500', 'text' => 'Từ chối']
                                    ];
                                    $config = $statusConfig[$job->status] ?? $statusConfig['closed'];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                                    {{ $config['text'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('recruiter.jobs.edit', $job->id) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        data-bs-toggle="tooltip" title="Chỉnh sửa">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </a>
                                    <a href="{{ route('recruiter.applicants.listByJob', $job->id) }}"
                                        class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                        data-bs-toggle="tooltip" title="Xem ứng viên">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2">work_off</span>
                                <p>Chưa có tin tuyển dụng nào đang hoạt động</p>
                                <a href="{{ route('recruiter.jobs.create') }}"
                                    class="inline-block mt-3 text-blue-600 hover:underline">Đăng tin đầu tiên</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activeJobList->count() > 0)
            <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                <span class="text-xs text-gray-400">Hiển thị {{ $activeJobList->count() }} tin tuyển dụng</span>
                <a href="{{ route('recruiter.jobs.index') }}"
                    class="text-blue-600 text-sm font-semibold hover:underline flex items-center gap-1">
                    Xem tất cả
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Ứng viên mới nhất -->
    @if($recentApplications->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Ứng viên mới nhất</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Danh sách ứng viên vừa nộp hồ sơ gần đây</p>
                    </div>
                    <a href="{{ route('recruiter.applicants.index') }}"
                        class="text-blue-600 text-sm font-medium hover:underline">Xem tất cả →</a>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($recentApplications->take(5) as $application)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                {{ strtoupper(substr($application->candidate->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $application->candidate->user->name ?? 'Ứng viên chưa xác định' }}
                                </p>
                                <p class="text-xs text-gray-400">Ứng tuyển: {{ $application->jobPost->title ?? 'Không xác định' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            @if($application->match_score)
                                <div class="flex items-center gap-1 px-2 py-1 bg-amber-50 rounded-full">
                                    <span class="material-symbols-outlined text-amber-500 text-sm">star</span>
                                    <span
                                        class="text-sm font-semibold text-amber-600">{{ number_format($application->match_score, 1) }}/100</span>
                                </div>
                            @endif
                            <div class="text-xs text-gray-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                {{ $application->created_at->diffForHumans() }}
                            </div>
                            <a href="{{ route('recruiter.applicants.show', $application->id) }}"
                                class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                                Xem hồ sơ
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>

    @push('scripts')
        <script>
            // ============================================
            // CHART FUNCTIONALITY
            // ============================================

            /**
             * Chuyển đổi giữa biểu đồ tuần và tháng
             * @param {string} type - 'week' hoặc 'month'
             */
            async function switchChart(type) {
                const chartBars = document.getElementById('chartBars');
                const chartLoading = document.getElementById('chartLoading');
                const btnWeek = document.getElementById('btnWeek');
                const btnMonth = document.getElementById('btnMonth');
                const periodLabel = document.getElementById('chartPeriodLabel');

                // Vô hiệu hóa nút để tránh gửi nhiều yêu cầu
                btnWeek.disabled = true;
                btnMonth.disabled = true;

                // Hiển thị loading, ẩn biểu đồ
                chartBars.classList.add('hidden');
                chartLoading.classList.remove('hidden');

                try {
                    const response = await fetch('{{ route("recruiter.dashboard.chart-data") }}?type=' + type, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Cập nhật biểu đồ với dữ liệu mới
                        renderChart(data.chartData, type);

                        // Cập nhật nhãn thời gian và kiểu nút
                        if (type === 'week') {
                            periodLabel.innerHTML = `Tuần này (${data.weekRange.start} - ${data.weekRange.end})`;
                            btnWeek.className = 'px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-600 text-white shadow-sm';
                            btnMonth.className = 'px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200';
                        } else {
                            periodLabel.innerHTML = `Năm ${new Date().getFullYear()}`;
                            btnMonth.className = 'px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-600 text-white shadow-sm';
                            btnWeek.className = 'px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200';
                        }
                    } else {
                        console.error('Không thể tải dữ liệu biểu đồ:', data.message);
                    }
                } catch (error) {
                    console.error('Lỗi khi tải dữ liệu biểu đồ:', error);
                } finally {
                    // Ẩn loading, hiển thị biểu đồ, kích hoạt lại nút
                    chartLoading.classList.add('hidden');
                    chartBars.classList.remove('hidden');
                    btnWeek.disabled = false;
                    btnMonth.disabled = false;
                }
            }

            /**
             * Hiển thị biểu đồ cột dựa trên dữ liệu và loại
             * @param {Array} chartData - Mảng dữ liệu biểu đồ
             * @param {string} type - 'week' hoặc 'month'
             */
            function renderChart(chartData, type) {
                const container = document.getElementById('chartBars');
                if (!container) return;

                let html = '';

                if (type === 'week') {
                    for (let item of chartData) {
                        html += `
                                                    <div class="w-full flex flex-col items-center gap-2 group">
                                                        <div class="w-full bg-gradient-to-t from-gray-100 to-gray-50 rounded-t-lg transition-all duration-300 group-hover:from-blue-100 group-hover:to-blue-50 relative cursor-pointer"
                                                             style="height: ${Math.max(item.height, 5)}%">
                                                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg">
                                                                ${item.count} ứng viên
                                                            </div>
                                                        </div>
                                                        <span class="text-xs font-medium text-gray-500">${item.day}</span>
                                                        <span class="text-xs text-gray-400">${item.label}</span>
                                                    </div>
                                                `;
                    }
                } else {
                    for (let item of chartData) {
                        html += `
                                                    <div class="w-full flex flex-col items-center gap-2 group">
                                                        <div class="w-full bg-gradient-to-t from-gray-100 to-gray-50 rounded-t-lg transition-all duration-300 group-hover:from-blue-100 group-hover:to-blue-50 relative cursor-pointer"
                                                             style="height: ${Math.max(item.height, 5)}%">
                                                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg">
                                                                ${item.count} ứng viên
                                                            </div>
                                                        </div>
                                                        <span class="text-xs font-medium text-gray-500">${item.month}</span>
                                                    </div>
                                                `;
                    }
                }

                container.innerHTML = html;
            }

            // ============================================
            // CHỨC NĂNG TÌM KIẾM
            // ============================================

            /**
             * Tìm kiếm việc làm trong bảng
             */
            const searchInput = document.getElementById('searchJob');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const searchText = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.job-row');

                    rows.forEach(row => {
                        const jobTitle = row.getAttribute('data-job-title') || '';
                        if (jobTitle.includes(searchText)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // ============================================
            // KHỞI TẠO TOOLTIP (nếu Bootstrap có sẵn)
            // ============================================

            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function (el) {
                    new bootstrap.Tooltip(el);
                });
            }
        </script>
    @endpush
@endsection