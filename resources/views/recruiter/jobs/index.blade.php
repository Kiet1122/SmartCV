@extends('layouts.recruiter_layout')

@section('title', 'Quản lý tuyển dụng | The Curator')

@section('content')
    <div class="px-4 py-4 max-w-7xl mx-auto">

        <!-- Header & Quick Stats -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Quản lý tuyển dụng</h1>
                <p class="text-gray-500">
                    Bạn đang có <span
                        class="font-semibold text-blue-600">{{ $jobs->where('status', 'open')->count() }}</span> tin tuyển
                    dụng đang hoạt động
                </p>
            </div>
            <div class="mt-3 md:mt-0">
                <a href="{{ route('recruiter.jobs.create') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all">
                    <span class="material-symbols-outlined text-base">add</span>
                    <span class="font-semibold">Đăng tin mới</span>
                </a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-blue-500 text-2xl">work</span>
                    <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Tổng</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $jobs->count() }}</h2>
                <span class="text-xs text-gray-400">Tin tuyển dụng</span>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-green-500 text-2xl">check_circle</span>
                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">Đang mở</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $jobs->where('status', 'open')->count() }}</h2>
                <span class="text-xs text-gray-400">Đang hoạt động</span>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-amber-500 text-2xl">group</span>
                    <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Ứng viên</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ number_format($totalApplicants ?? 0) }}</h2>
                <span class="text-xs text-gray-400">Tổng ứng viên</span>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-gray-400 text-2xl">archive</span>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Đã đóng</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $jobs->where('status', 'closed')->count() }}</h2>
                <span class="text-xs text-gray-400">Đã kết thúc</span>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-col md:flex-row justify-between gap-3 mb-6">
            <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                <input type="text" id="searchJobs"
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400"
                    placeholder="Tìm kiếm theo tiêu đề...">
            </div>
            <div class="flex gap-3">
                <select id="statusFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📋 Tất cả trạng thái</option>
                    <option value="pending">🟡 Đang kiểm duyệt</option>
                    <option value="open">🟢 Đang mở</option>
                    <option value="rejected">🔴 Bị từ chối</option>
                    <option value="closed">⚫ Đã đóng</option>
                </select>
                <select id="dateFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📅 Tất cả thời gian</option>
                    <option value="week">Tuần này</option>
                    <option value="month">Tháng này</option>
                    <option value="year">Năm nay</option>
                </select>
            </div>
        </div>

        <!-- Job Cards -->
        <div class="space-y-3" id="jobsContainer">
            @forelse($jobs as $job)
                <div class="job-card bg-white rounded-xl shadow-sm border border-gray-100 p-4 transition-all hover:shadow-md"
                    data-status="{{ $job->status }}" data-title="{{ Str::slug($job->title) }}"
                    data-date="{{ $job->created_at->timestamp }}">

                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <!-- Thông tin chính -->
                        <div class="flex-1">
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-blue-500 text-2xl">work</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <h3 class="job-title font-bold text-gray-900 text-lg">{{ $job->title }}</h3>
                                        @if($job->status === 'pending')
                                            <span
                                                class="inline-flex items-center gap-1 text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">
                                                <span class="material-symbols-outlined text-sm">pending</span>
                                                Chờ duyệt
                                            </span>
                                        @elseif($job->status === 'rejected')
                                            <span
                                                class="inline-flex items-center gap-1 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">
                                                <span class="material-symbols-outlined text-sm">error</span>
                                                Từ chối
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                                            <span class="material-symbols-outlined text-sm">payments</span>
                                            {{ $job->salary_range ?? 'Thỏa thuận' }}
                                        </span>
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                                            <span class="material-symbols-outlined text-sm">timeline</span>
                                            {{ $job->experience_required ?? 'Không yêu cầu' }} năm
                                        </span>
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                                            <span class="material-symbols-outlined text-sm">schedule</span>
                                            Đăng: {{ $job->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kỹ năng -->
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-1.5">
                                @php $jobSkills = $job->skills->take(3); @endphp
                                @foreach($jobSkills as $skill)
                                    <span
                                        class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $skill->name }}</span>
                                @endforeach
                                @if($job->skills->count() > 3)
                                    <span
                                        class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">+{{ $job->skills->count() - 3 }}</span>
                                @endif
                                @if($jobSkills->isEmpty())
                                    <span class="text-xs text-gray-400">Chưa có kỹ năng</span>
                                @endif
                            </div>
                        </div>

                        <!-- Số ứng viên -->
                        <div class="text-center min-w-[80px]">
                            <div class="w-12 h-12 mx-auto bg-blue-50 rounded-full flex items-center justify-center">
                                <span class="font-bold text-blue-600 text-lg">{{ $job->applications_count ?? 0 }}</span>
                            </div>
                            <span class="text-xs text-gray-400">ứng viên</span>
                        </div>

                        <!-- Trạng thái & Action -->
                        <div class="flex items-center justify-between min-w-[140px]">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ 
                                                        $job->status === 'open' ? 'bg-green-100 text-green-700' :
                ($job->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                    ($job->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600')) 
                                                    }}">
                                {{ $job->status === 'open' ? 'Đang mở' :
                ($job->status === 'pending' ? 'Đang kiểm duyệt' :
                    ($job->status === 'rejected' ? 'Bị từ chối' : 'Đã đóng')) }}
                            </span>

                            <!-- Dropdown 3 chấm -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                    <span class="material-symbols-outlined text-gray-400">more_vert</span>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-10"
                                    x-cloak>
                                    @if($job->status === 'open')
                                        <form action="{{ route('recruiter.jobs.close', $job->id) }}" method="POST" class="block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Bạn có chắc chắn muốn đóng tin tuyển dụng này?')"
                                                class="flex items-center w-full gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                <span class="material-symbols-outlined text-red-500 text-base">block</span>
                                                Đóng tin
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('recruiter.jobs.edit', $job->id) }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <span class="material-symbols-outlined text-amber-500 text-base">edit</span>
                                        Chỉnh sửa
                                    </a>
                                    <button type="button"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $job->id }}">
                                        <span class="material-symbols-outlined text-red-500 text-base">delete</span>
                                        Xóa tin
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $job->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-2xl border-0">
                            <div class="text-center p-6">
                                <div class="w-16 h-16 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-red-500 text-3xl">warning</span>
                                </div>
                                <h5 class="text-xl font-bold text-gray-900 mb-2">Xóa tin tuyển dụng?</h5>
                                <p class="text-gray-500 mb-6">Bạn có chắc muốn xóa "{{ $job->title }}" không?<br>Hành động này
                                    không thể hoàn tác.</p>
                                <div class="flex gap-3 justify-center">
                                    <button type="button"
                                        class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition"
                                        data-bs-dismiss="modal">Hủy</button>
                                    <form action="{{ route('recruiter.jobs.destroy', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-5 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">Xóa
                                            ngay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-gray-400 text-3xl">work_off</span>
                    </div>
                    <h5 class="text-lg font-semibold text-gray-900 mb-2">Chưa có tin tuyển dụng nào</h5>
                    <p class="text-gray-500 mb-4">Hãy đăng tin tuyển dụng đầu tiên để bắt đầu</p>
                    <a href="{{ route('recruiter.jobs.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined text-base">add</span>
                        Đăng tin ngay
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .job-card {
            transition: all 0.25s ease;
        }

        .job-card:hover {
            transform: translateY(-2px);
            border-color: #e5e7eb;
        }
    </style>

    <script>
        // Filter functionality
        function filterJobs() {
            const searchTerm = document.getElementById('searchJobs')?.value.toLowerCase() || '';
            const statusFilter = document.getElementById('statusFilter')?.value || 'all';

            const cards = document.querySelectorAll('.job-card');

            cards.forEach(card => {
                let show = true;

                if (searchTerm) {
                    const title = card.querySelector('.job-title')?.textContent.toLowerCase() || '';
                    if (!title.includes(searchTerm)) show = false;
                }

                if (show && statusFilter !== 'all') {
                    const status = card.dataset.status;
                    if (status !== statusFilter) show = false;
                }

                card.style.display = show ? 'block' : 'none';
            });
        }

        document.getElementById('searchJobs')?.addEventListener('keyup', filterJobs);
        document.getElementById('statusFilter')?.addEventListener('change', filterJobs);
    </script>
@endsection