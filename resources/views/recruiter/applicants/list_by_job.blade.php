@extends('layouts.recruiter_layout')

@section('title', 'Ứng viên cho vị trí | The Curator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Navigation & Header -->
        <div class="mb-6">
            <a href="{{ route('recruiter.applicants.index') }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors mb-4">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Quay lại danh sách Job</span>
            </a>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 text-2xl">group</span>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                        <div class="flex items-center gap-3 mt-1">
                            @php
                                $statusConfig = [
                                    'open' => ['class' => 'bg-green-100 text-green-700', 'text' => 'Đang tuyển', 'icon' => 'check_circle'],
                                    'pending' => ['class' => 'bg-amber-100 text-amber-700', 'text' => 'Chờ duyệt', 'icon' => 'pending'],
                                    'closed' => ['class' => 'bg-gray-100 text-gray-600', 'text' => 'Đã đóng', 'icon' => 'archive']
                                ];
                                $status = $statusConfig[$job->status] ?? $statusConfig['closed'];
                            @endphp
                            <span
                                class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full {{ $status['class'] }}">
                                <span class="material-symbols-outlined text-sm">{{ $status['icon'] }}</span>
                                {{ $status['text'] }}
                            </span>
                            <span class="text-sm text-gray-400">|</span>
                            <span class="text-sm text-gray-500">
                                <span class="font-semibold text-blue-600">{{ $applications->count() }}</span> hồ sơ ứng
                                tuyển
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="flex gap-3">
                    <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-gray-100">
                        <div class="text-xs text-gray-400">Điểm TB</div>
                        <div class="font-semibold text-gray-900">{{ round($applications->avg('match_score') ?? 0) }}%</div>
                    </div>
                    <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-gray-100">
                        <div class="text-xs text-gray-400">Chờ xét duyệt</div>
                        <div class="font-semibold text-amber-600">{{ $applications->where('status', 'pending')->count() }}
                        </div>
                    </div>
                    <div class="bg-white rounded-xl px-4 py-2 shadow-sm border border-gray-100">
                        <div class="text-xs text-gray-400">Đã duyệt</div>
                        <div class="font-semibold text-green-600">{{ $applications->where('status', 'approved')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row justify-between gap-3 mb-6">
            <div class="relative flex-1 max-w-sm">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                <input type="text" id="searchApplicant"
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400"
                    placeholder="Tìm kiếm theo tên hoặc email...">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📋 Tất cả trạng thái</option>
                    <option value="pending">🟡 Chờ xét duyệt</option>
                    <option value="approved">🟢 Đã duyệt</option>
                    <option value="rejected">🔴 Từ chối</option>
                    <option value="shortlisted">⭐ Đã lưu</option>
                </select>
                <select id="scoreFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📊 Tất cả điểm</option>
                    <option value="high">⭐ Cao (>75%)</option>
                    <option value="medium">📌 Trung bình (50-75%)</option>
                    <option value="low">⚠️ Thấp (<50%)< /option>
                </select>
            </div>
        </div>

        <!-- Applications Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ứng
                                viên</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Điểm AI</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Trạng thái</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngày nộp</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="applicantsTable">
                        @forelse($applications as $app)
                            @php
                                $score = $app->match_score ?? 0;
                                if ($score >= 75) {
                                    $scoreClass = 'bg-green-100 text-green-700';
                                    $scoreLabel = 'Xuất sắc';
                                } elseif ($score >= 50) {
                                    $scoreClass = 'bg-amber-100 text-amber-700';
                                    $scoreLabel = 'Tiềm năng';
                                } else {
                                    $scoreClass = 'bg-red-100 text-red-700';
                                    $scoreLabel = 'Cần cải thiện';
                                }

                                $statusConfig = [
                                    'pending' => ['class' => 'bg-amber-100 text-amber-700', 'icon' => 'pending', 'text' => 'Chờ duyệt'],
                                    'approved' => ['class' => 'bg-green-100 text-green-700', 'icon' => 'check_circle', 'text' => 'Đã duyệt'],
                                    'rejected' => ['class' => 'bg-red-100 text-red-700', 'icon' => 'cancel', 'text' => 'Từ chối'],
                                    'shortlisted' => ['class' => 'bg-purple-100 text-purple-700', 'icon' => 'star', 'text' => 'Đã lưu']
                                ];
                                $appStatus = $statusConfig[$app->status] ?? $statusConfig['pending'];
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors applicant-row"
                                data-name="{{ strtolower($app->candidate->user->name) }}"
                                data-email="{{ strtolower($app->candidate->user->email) }}" data-status="{{ $app->status }}"
                                data-score="{{ $score }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                            {{ strtoupper(substr($app->candidate->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $app->candidate->user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $app->candidate->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span
                                            class="text-lg font-bold {{ $score >= 75 ? 'text-green-600' : ($score >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                            {{ number_format($score, 1) }}%
                                        </span>
                                        <span
                                            class="text-xs px-2 py-0.5 rounded-full {{ $scoreClass }} mt-1">{{ $scoreLabel }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1.5 rounded-full {{ $appStatus['class'] }}">
                                        <span class="material-symbols-outlined text-sm">{{ $appStatus['icon'] }}</span>
                                        {{ $appStatus['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $app->created_at->format('d/m/Y') }}
                                    <div class="text-xs text-gray-400">{{ $app->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('recruiter.applicants.show', $app->id) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-sm font-medium hover:bg-blue-100 transition-colors">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <span class="material-symbols-outlined text-gray-400 text-2xl">person_off</span>
                                        </div>
                                        <p class="text-gray-500 font-medium">Chưa có ứng viên nào</p>
                                        <p class="text-sm text-gray-400 mt-1">Chưa có hồ sơ ứng tuyển cho vị trí này</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($applications, 'links') && $applications->hasPages())
            <div class="mt-6">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

    <!-- Filter Script -->
    <script>
        function filterTable() {
            const searchTerm = document.getElementById('searchApplicant')?.value.toLowerCase() || '';
            const statusFilter = document.getElementById('statusFilter')?.value || 'all';
            const scoreFilter = document.getElementById('scoreFilter')?.value || 'all';

            const rows = document.querySelectorAll('.applicant-row');

            rows.forEach(row => {
                let show = true;

                // Search filter
                if (searchTerm) {
                    const name = row.dataset.name || '';
                    const email = row.dataset.email || '';
                    if (!name.includes(searchTerm) && !email.includes(searchTerm)) show = false;
                }

                // Status filter
                if (show && statusFilter !== 'all') {
                    const status = row.dataset.status;
                    if (status !== statusFilter) show = false;
                }

                // Score filter
                if (show && scoreFilter !== 'all') {
                    const score = parseFloat(row.dataset.score || 0);
                    if (scoreFilter === 'high' && score < 75) show = false;
                    if (scoreFilter === 'medium' && (score < 50 || score >= 75)) show = false;
                    if (scoreFilter === 'low' && score >= 50) show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        document.getElementById('searchApplicant')?.addEventListener('keyup', filterTable);
        document.getElementById('statusFilter')?.addEventListener('change', filterTable);
        document.getElementById('scoreFilter')?.addEventListener('change', filterTable);
    </script>
@endsection