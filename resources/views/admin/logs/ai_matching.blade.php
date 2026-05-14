@extends('layouts.admin_layout')

@section('title', 'Lịch sử Matching AI | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-2xl">psychology</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 font-headline">Lịch sử Matching AI</h1>
                        <p class="text-gray-500 mt-1">Theo dõi lịch sử ghép nối ứng viên bằng trí tuệ nhân tạo</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng số lượt matching</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $logs->total() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-purple-500">history</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Điểm trung bình</p>
                        <p class="text-2xl font-bold text-amber-600">{{ round($logs->avg('final_score'), 1) }}%</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-amber-500">star</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Model phổ biến</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $logs->groupBy('model_used')->sortByDesc(fn($group) => $group->count())->keys()->first() ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-500">memory</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Thời gian xử lý TB</p>
                        <p class="text-2xl font-bold text-green-600">{{ round($logs->avg('processing_time_ms')) }} ms</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-500">speed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                <input type="text" id="searchLogs" placeholder="Tìm kiếm theo công việc, model..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-400 transition-all">
            </div>
            <select id="modelFilter"
                class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                <option value="all">🔬 Tất cả model</option>
                @foreach($logs->groupBy('model_used')->keys() as $model)
                    <option value="{{ $model }}">{{ $model }}</option>
                @endforeach
            </select>
            <select id="scoreFilter"
                class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                <option value="all">📊 Tất cả điểm</option>
                <option value="high">⭐ Cao (>75%)</option>
                <option value="medium">📌 Trung bình (50-75%)</option>
                <option value="low">⚠️ Thấp (<50%)< /option>
            </select>
            <button id="resetFilters"
                class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                <span class="material-symbols-outlined text-base align-middle">refresh</span>
                Đặt lại
            </button>
        </div>

        <!-- Logs Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full" id="logsTable">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Công việc</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Model</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Raw
                                Score</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Final Score</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thời gian</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="logsTableBody">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/50 transition-colors log-row"
                                data-job="{{ strtolower($log->job_title) }}" data-model="{{ $log->model_used }}"
                                data-score="{{ $log->final_score }}">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $log->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-blue-500 text-sm">work</span>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $log->job_title }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        <span class="material-symbols-outlined text-sm">memory</span>
                                        {{ $log->model_used }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                            <div class="bg-gray-500 h-1.5 rounded-full"
                                                style="width: {{ min($log->raw_score * 100, 100) }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ number_format($log->raw_score, 4) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $score = $log->final_score;
                                        $scoreClass = $score >= 75 ? 'text-green-600 bg-green-50' : ($score >= 50 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50');
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $scoreClass }}">
                                        <span class="material-symbols-outlined text-sm">star</span>
                                        {{ $score }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-gray-400 text-sm">schedule</span>
                                        {{ $log->processing_time_ms }} ms
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}
                                    <div class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <div
                                            class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-gray-400 text-3xl">psychology</span>
                                        </div>
                                        <h5 class="text-lg font-semibold text-gray-900 mb-2">Chưa có dữ liệu matching</h5>
                                        <p class="text-gray-500">Chưa có lượt ghép nối AI nào được ghi nhận</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Search and Filter functionality
        const searchInput = document.getElementById('searchLogs');
        const modelFilter = document.getElementById('modelFilter');
        const scoreFilter = document.getElementById('scoreFilter');
        const resetBtn = document.getElementById('resetFilters');
        const rows = document.querySelectorAll('.log-row');

        function filterLogs() {
            const searchTerm = searchInput?.value.toLowerCase() || '';
            const model = modelFilter?.value || 'all';
            const score = scoreFilter?.value || 'all';

            rows.forEach(row => {
                const jobTitle = row.dataset.job || '';
                const rowModel = row.dataset.model || '';
                const rowScore = parseFloat(row.dataset.score || 0);

                let show = true;

                // Search filter
                if (searchTerm && !jobTitle.includes(searchTerm)) {
                    show = false;
                }

                // Model filter
                if (show && model !== 'all' && rowModel !== model) {
                    show = false;
                }

                // Score filter
                if (show && score !== 'all') {
                    if (score === 'high' && rowScore < 75) show = false;
                    if (score === 'medium' && (rowScore < 50 || rowScore >= 75)) show = false;
                    if (score === 'low' && rowScore >= 50) show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        searchInput?.addEventListener('keyup', filterLogs);
        modelFilter?.addEventListener('change', filterLogs);
        scoreFilter?.addEventListener('change', filterLogs);

        resetBtn?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (modelFilter) modelFilter.value = 'all';
            if (scoreFilter) scoreFilter.value = 'all';
            filterLogs();
        });
    </script>
@endsection