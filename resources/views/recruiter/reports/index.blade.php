@extends('layouts.recruiter_layout')

@section('title', 'Báo cáo hiệu quả tuyển dụng | The Curator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">analytics</span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Báo cáo hiệu quả tuyển dụng</h1>
                    <p class="text-gray-500 mt-1">Tổng quan hiệu suất tuyển dụng và phân tích dữ liệu</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Jobs -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 text-xl">work</span>
                    </div>
                    <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Tổng</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_jobs'] }}</h3>
                <p class="text-sm text-gray-500 mt-1">Tổng tin đăng</p>
            </div>

            <!-- Active Jobs -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-600 text-xl">check_circle</span>
                    </div>
                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">Đang hoạt động</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $stats['active_jobs'] }}</h3>
                <p class="text-sm text-gray-500 mt-1">Tin đang hoạt động</p>
            </div>

            <!-- Total Applicants -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-amber-600 text-xl">group</span>
                    </div>
                    <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Tổng</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_applicants']) }}</h3>
                <p class="text-sm text-gray-500 mt-1">Tổng số ứng viên</p>
            </div>

            <!-- High Match Count -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-purple-600 text-xl">psychology</span>
                    </div>
                    <span class="text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded-full">AI > 80%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['high_match_count']) }}</h3>
                <p class="text-sm text-gray-500 mt-1">Ứng viên tiềm năng</p>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Status Distribution Chart -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50/30">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">pie_chart</span>
                        <h3 class="font-semibold text-gray-800">Phân bổ trạng thái hồ sơ</h3>
                    </div>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        @foreach($statusDistribution as $status)
                            @php
                                $percent = $stats['total_applicants'] > 0 ? ($status->total / $stats['total_applicants']) * 100 : 0;
                                $barColor = match ($status->status) {
                                    'pending' => 'bg-amber-500',
                                    'approved' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    'shortlisted' => 'bg-purple-500',
                                    default => 'bg-blue-500'
                                };
                                $bgColor = match ($status->status) {
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'approved' => 'bg-green-50 text-green-700',
                                    'rejected' => 'bg-red-50 text-red-700',
                                    'shortlisted' => 'bg-purple-50 text-purple-700',
                                    default => 'bg-blue-50 text-blue-700'
                                };
                                $icon = match ($status->status) {
                                    'pending' => 'pending',
                                    'approved' => 'check_circle',
                                    'rejected' => 'cancel',
                                    'shortlisted' => 'star',
                                    default => 'description'
                                };
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="material-symbols-outlined text-sm {{ str_replace('bg-', 'text-', $bgColor) }}">{{ $icon }}</span>
                                        <span class="text-sm font-medium text-gray-700">{{ ucfirst($status->status) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-sm font-semibold text-gray-900">{{ number_format($status->total) }}</span>
                                        <span class="text-xs text-gray-400">{{ round($percent) }}%</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full transition-all duration-500 {{ $barColor }}"
                                        style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Jobs Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50/30">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">trending_up</span>
                        <h3 class="font-semibold text-gray-800">Top tin tuyển dụng thu hút nhất</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Vị trí</th>
                                <th
                                    class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Số hồ sơ</th>
                                <th
                                    class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Điểm TB</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topJobs as $index => $job)
                                @php
                                    $avgScore = round($job->applications->avg('match_score') ?? 0, 1);
                                    $scoreColor = $avgScore >= 75 ? 'text-green-600' : ($avgScore >= 50 ? 'text-amber-600' : 'text-red-600');
                                    $rankColor = match ($index) {
                                        0 => 'text-amber-500',
                                        1 => 'text-gray-500',
                                        2 => 'text-orange-500',
                                        default => 'text-gray-400'
                                    };
                                    $rankIcon = match ($index) {
                                        0 => 'emoji_events',
                                        1 => 'workspace_premium',
                                        2 => 'military_tech',
                                        default => 'trending_up'
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center {{ $rankColor }}">
                                                <span class="material-symbols-outlined text-sm">{{ $rankIcon }}</span>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">{{ Str::limit($job->title, 40) }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5">
                                                    {{ $job->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center min-w-[40px] px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-semibold">
                                            {{ number_format($job->applications_count) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="text-sm font-semibold {{ $scoreColor }}">
                                            {{ $avgScore }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center text-gray-400">
                                        <span class="material-symbols-outlined text-3xl mb-2">bar_chart_off</span>
                                        <p>Chưa có dữ liệu</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Additional Insight Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Conversion Rate -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">conversion_path</span>
                        <span class="text-sm font-semibold text-gray-700">Tỷ lệ chuyển đổi</span>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">
                        {{ $stats['total_applicants'] > 0 ? round(($stats['high_match_count'] / $stats['total_applicants']) * 100) : 0 }}%
                    </span>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $stats['total_applicants'] > 0 ? ($stats['high_match_count'] / $stats['total_applicants']) * 100 : 0 }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Tỷ lệ ứng viên tiềm năng (AI > 80%) trên tổng số</p>
            </div>

            <!-- Average AI Score -->
            <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-5 border border-emerald-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600">score</span>
                        <span class="text-sm font-semibold text-gray-700">Điểm AI trung bình</span>
                    </div>
                    <span class="text-2xl font-bold text-emerald-600">{{ round($stats['avg_match_score'] ?? 0) }}%</span>
                </div>
                <div class="w-full bg-emerald-200 rounded-full h-2">
                    <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $stats['avg_match_score'] ?? 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Điểm phù hợp trung bình của tất cả ứng viên</p>
            </div>

            <!-- Response Rate -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-5 border border-purple-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-purple-600">rate_review</span>
                        <span class="text-sm font-semibold text-gray-700">Tỷ lệ phản hồi</span>
                    </div>
                    <span class="text-2xl font-bold text-purple-600">
                        {{ $stats['total_applicants'] > 0 ? round((($stats['total_applicants'] - ($statusDistribution->where('status', 'pending')->first()->total ?? 0)) / $stats['total_applicants']) * 100) : 0 }}%
                    </span>
                </div>
                <div class="w-full bg-purple-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $stats['total_applicants'] > 0 ? ((($stats['total_applicants'] - ($statusDistribution->where('status', 'pending')->first()->total ?? 0)) / $stats['total_applicants']) * 100) : 0 }}%">
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Tỷ lệ hồ sơ đã được xử lý (duyệt/từ chối)</p>
            </div>
        </div>

        <!-- Export Button -->
        <div class="mt-8 flex justify-end">
            <button
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                <span class="material-symbols-outlined text-base">download</span>
                Xuất báo cáo (PDF)
            </button>
        </div>
    </div>
@endsection