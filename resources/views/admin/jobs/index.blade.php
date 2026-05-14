@extends('layouts.admin_layout')

@section('title', 'Quản lý tin tuyển dụng | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-headline">Quản lý tin tuyển dụng</h1>
                <p class="text-gray-500 mt-1">Quản lý tất cả tin tuyển dụng trên hệ thống</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-base">download</span>
                    Xuất Excel
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng tin tuyển dụng</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $jobs->total() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-500">work</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Đang mở</p>
                        <p class="text-2xl font-bold text-green-600">{{ $jobs->where('status', 'open')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-500">check_circle</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Chờ duyệt</p>
                        <p class="text-2xl font-bold text-amber-600">{{ $jobs->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-amber-500">pending</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Đã đóng</p>
                        <p class="text-2xl font-bold text-gray-600">{{ $jobs->where('status', 'closed')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-gray-500">archive</span>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl p-4 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-white/80">Tổng ứng viên</p>
                        <p class="text-2xl font-bold text-white">
                            {{ $jobs->sum(function ($job) {
        return $job->applications_count ?? 0; }) }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">group</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="flex flex-col md:flex-row justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo tiêu đề, công ty..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
            </div>
            <div class="flex gap-3">
                <select id="statusFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📋 Tất cả trạng thái</option>
                    <option value="open">🟢 Đang mở</option>
                    <option value="pending">🟡 Chờ duyệt</option>
                    <option value="closed">⚫ Đã đóng</option>
                </select>
                <button id="resetFilters"
                    class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-base align-middle">refresh</span>
                    Đặt lại
                </button>
            </div>
        </div>

        <!-- Jobs Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full" id="jobsTable">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tin
                                tuyển dụng</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Công ty</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ứng
                                viên</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Lượt xem</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Trạng thái</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngày đăng</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($jobs as $job)
                            @php
                                $applicationsCount = $job->applications_count ?? $job->applications->count() ?? 0;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors job-row" data-title="{{ strtolower($job->title) }}"
                                data-company="{{ strtolower($job->company->company_name ?? '') }}"
                                data-status="{{ $job->status }}">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $job->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-700 font-bold text-sm shrink-0 mt-0.5">
                                            {{ strtoupper(substr($job->title, 0, 2)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-gray-900 truncate max-w-xs">{{ $job->title }}</div>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <span class="inline-flex items-center gap-0.5 text-xs text-gray-400">
                                                    <span class="material-symbols-outlined text-xs">payments</span>
                                                    {{ $job->salary_range ?? 'Thỏa thuận' }}
                                                </span>
                                                <span class="inline-flex items-center gap-0.5 text-xs text-gray-400">
                                                    <span class="material-symbols-outlined text-xs">timeline</span>
                                                    {{ $job->experience_required ?? '0' }} năm
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($job->company && $job->company->logo_url)
                                            <img src="{{ asset('storage/' . $job->company->logo_url) }}"
                                                alt="{{ $job->company->company_name }}" class="w-6 h-6 rounded-full object-cover">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-xs text-gray-500">business</span>
                                            </div>
                                        @endif
                                        <span
                                            class="text-sm text-gray-700 truncate max-w-[150px]">{{ $job->company->company_name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600">
                                        <span class="material-symbols-outlined text-sm">group</span>
                                        {{ number_format($applicationsCount) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-gray-400 text-sm">visibility</span>
                                        {{ number_format($job->views_count ?? 0) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'open' => ['class' => 'bg-green-100 text-green-700', 'icon' => 'check_circle', 'text' => 'Đang mở'],
                                            'pending' => ['class' => 'bg-amber-100 text-amber-700', 'icon' => 'pending', 'text' => 'Chờ duyệt'],
                                            'closed' => ['class' => 'bg-gray-100 text-gray-600', 'icon' => 'archive', 'text' => 'Đã đóng'],
                                        ];
                                        $config = $statusConfig[$job->status] ?? $statusConfig['closed'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                        <span class="material-symbols-outlined text-sm">{{ $config['icon'] }}</span>
                                        {{ $config['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $job->created_at->format('d/m/Y') }}
                                    <div class="text-xs text-gray-400">{{ $job->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="viewJob({{ $job->id }})"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                            title="Xem chi tiết">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                    <span class="material-symbols-outlined text-4xl mb-2">work_off</span>
                                    <p>Chưa có tin tuyển dụng nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>

    <script>
        // Search and Filter functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetFilters');
        const rows = document.querySelectorAll('.job-row');

        function filterJobs() {
            const searchTerm = searchInput?.value.toLowerCase() || '';
            const status = statusFilter?.value || 'all';

            rows.forEach(row => {
                const title = row.dataset.title || '';
                const company = row.dataset.company || '';
                const rowStatus = row.dataset.status || '';

                let show = true;

                if (searchTerm && !title.includes(searchTerm) && !company.includes(searchTerm)) {
                    show = false;
                }

                if (show && status !== 'all' && rowStatus !== status) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        searchInput?.addEventListener('keyup', filterJobs);
        statusFilter?.addEventListener('change', filterJobs);

        resetBtn?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = 'all';
            filterJobs();
        });

        // View job
        function viewJob(id) {
            window.location.href = `/admin/jobs/${id}`;
        }

        // Delete modal functions
        let deleteJobId = null;

        function deleteJob(id, title) {
            deleteJobId = id;
            const modal = document.getElementById('deleteModal');
            const jobTitleSpan = document.getElementById('deleteJobTitle');
            const deleteForm = document.getElementById('deleteForm');

            jobTitleSpan.textContent = title;
            deleteForm.action = `/admin/jobs/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            deleteJobId = null;
        }

        // Approve modal functions
        let approveJobId = null;

        function approveJob(id) {
            approveJobId = id;
            const modal = document.getElementById('approveModal');
            const jobTitleSpan = document.getElementById('approveJobTitle');
            const approveForm = document.getElementById('approveForm');
            const job = rows.find(row => row.dataset.jobId == id);

            // Get job title from the row
            const titleElement = document.querySelector(`tr[data-job-id="${id}"] .font-semibold`);
            jobTitleSpan.textContent = titleElement ? titleElement.textContent : 'này';
            approveForm.action = `/admin/jobs/${id}/approve`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeApproveModal() {
            const modal = document.getElementById('approveModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            approveJobId = null;
        }

        // Close modals when clicking outside
        document.getElementById('deleteModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });

        document.getElementById('approveModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeApproveModal();
        });
    </script>
@endsection