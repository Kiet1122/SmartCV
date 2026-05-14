@extends('layouts.admin_layout')

@section('title', 'Dashboard | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 font-headline">Tổng quan hệ thống</h1>
            <p class="text-gray-500 mt-1">Theo dõi hiệu suất và thống kê toàn bộ nền tảng</p>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Users Card -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                        <span class="material-symbols-outlined text-blue-600 text-2xl">group</span>
                    </div>
                    <span
                        class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full group-hover:bg-blue-100">Tổng</span>
                </div>
                <h3 class="text-sm text-gray-500 mb-1">Tổng người dùng</h3>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</div>
                <div class="flex items-center gap-1 mt-2 text-xs text-green-600">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>+12% so với tháng trước</span>
                </div>
            </div>

            <!-- Total Jobs Card -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl">work</span>
                    </div>
                    <span
                        class="text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full group-hover:bg-emerald-100">Tổng</span>
                </div>
                <h3 class="text-sm text-gray-500 mb-1">Tin tuyển dụng</h3>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_jobs']) }}</div>
                <div class="text-xs text-gray-400 mt-2">{{ $stats['active_jobs'] ?? 0 }} tin đang hoạt động</div>
            </div>

            <!-- Total Applications Card -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition">
                        <span class="material-symbols-outlined text-amber-600 text-2xl">description</span>
                    </div>
                    <span
                        class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full group-hover:bg-amber-100">Tổng</span>
                </div>
                <h3 class="text-sm text-gray-500 mb-1">Lượt ứng tuyển</h3>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_applications']) }}</div>
                <div class="text-xs text-gray-400 mt-2">Tỷ lệ chuyển đổi: {{ $stats['conversion_rate'] ?? 0 }}%</div>
            </div>

            <!-- Avg AI Score Card -->
            <div
                class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-2xl">psychology</span>
                    </div>
                    <span class="text-xs text-white/80 bg-white/20 px-2 py-1 rounded-full">AI</span>
                </div>
                <h3 class="text-sm text-white/80 mb-1">Điểm AI trung bình</h3>
                <div class="text-4xl font-bold text-white">{{ $stats['avg_match_score'] }}%</div>
                <div class="text-xs text-white/60 mt-2">Độ chính xác ngày càng cải thiện</div>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

            <!-- Recent Jobs Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-500">schedule</span>
                                Tin tuyển dụng mới nhất
                            </h3>
                            <p class="text-sm text-gray-500 mt-0.5">5 công việc gần đây được đăng tải</p>
                        </div>
                        <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Xem tất cả →</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Công việc</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Công ty</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ngày đăng</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentJobs as $job)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">{{ $job->title }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($job->description ?? '', 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                            <span class="material-symbols-outlined text-base">business</span>
                                            {{ $job->company->company_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $job->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                        <span class="material-symbols-outlined text-3xl mb-2">work_off</span>
                                        <p>Chưa có tin tuyển dụng nào</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Candidates Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-amber-500">star</span>
                                Top ứng viên tiềm năng
                            </h3>
                            <p class="text-sm text-gray-500 mt-0.5">5 ứng viên có điểm AI cao nhất</p>
                        </div>
                        <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Xem tất cả →</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ứng viên</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vị trí</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Điểm Match
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($topMatches as $match)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs">
                                                {{ strtoupper(substr($match->candidate_name, 0, 2)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $match->candidate_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $match->job_title }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $score = $match->match_score;
                                            $scoreColor = $score >= 70 ? 'green' : ($score >= 40 ? 'orange' : 'red');
                                            $scoreBg = $score >= 70 ? 'bg-green-100 text-green-700' : ($score >= 40 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700');
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $scoreBg }}">
                                            <span class="material-symbols-outlined text-sm">star</span>
                                            {{ $score }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                        <span class="material-symbols-outlined text-3xl mb-2">person_off</span>
                                        <p>Chưa có dữ liệu ứng viên</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent AI Matching Logs Link -->
        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.logs.ai_matching') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                <span class="material-symbols-outlined text-base">analytics</span>
                <span>Xem chi tiết Log Matching AI</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>
    </div>
@endsection