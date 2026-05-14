@extends('layouts.admin_layout')

@section('title', 'Chi tiết tin tuyển dụng | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Back Button -->
        <div>
            <a href="{{ route('admin.jobs.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Quay lại danh sách</span>
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Header with Gradient -->
            <div class="relative px-6 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-6xl">work</span>
                </div>
                <div class="relative z-10">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                <span class="material-symbols-outlined text-white text-3xl">work</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white mb-1">{{ $job->title }}</h1>
                                <div class="flex items-center gap-2">
                                    <span class="text-blue-100 text-sm">ID: #{{ $job->id }}</span>
                                    <span class="w-1 h-1 bg-blue-300 rounded-full"></span>
                                    <span class="text-blue-100 text-sm">{{ $job->company->company_name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            @php
                                $statusConfig = [
                                    'open' => ['class' => 'bg-green-500', 'icon' => 'check_circle', 'text' => 'Đang mở'],
                                    'pending' => ['class' => 'bg-amber-500', 'icon' => 'pending', 'text' => 'Chờ duyệt'],
                                    'closed' => ['class' => 'bg-gray-500', 'icon' => 'archive', 'text' => 'Đã đóng'],
                                ];
                                $config = $statusConfig[$job->status] ?? $statusConfig['closed'];
                            @endphp
                            <span
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold text-white {{ $config['class'] }} shadow-md">
                                <span class="material-symbols-outlined text-base">{{ $config['icon'] }}</span>
                                {{ $config['text'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="p-6 border-b border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Salary -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-green-600">payments</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Mức lương</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $job->salary_range ?? 'Thỏa thuận' }}</p>
                        </div>
                    </div>

                    <!-- Experience -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-blue-600">timeline</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Kinh nghiệm</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $job->experience_required ?? 0 }} năm</p>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-purple-600">school</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Trình độ</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $job->education_required ?? 'Không yêu cầu' }}
                            </p>
                        </div>
                    </div>

                    <!-- Views -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-amber-600">visibility</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Lượt xem</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ number_format($job->views_count ?? 0) }}</p>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-indigo-600">calendar_today</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Ngày đăng</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $job->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Updated Date -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-gray-500">update</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-semibold">Cập nhật</p>
                            <p class="font-semibold text-gray-800 mt-0.5">{{ $job->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Info -->
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    @if($job->company && $job->company->logo_url)
                        <img src="{{ asset('storage/' . $job->company->logo_url) }}" alt="{{ $job->company->company_name }}"
                            class="w-12 h-12 rounded-xl object-cover shadow-sm">
                    @else
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <span class="material-symbols-outlined text-gray-500 text-2xl">business</span>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Công ty tuyển dụng</p>
                        <p class="font-semibold text-gray-800">{{ $job->company->company_name ?? 'N/A' }}</p>
                        @if($job->company && $job->company->email)
                            <p class="text-sm text-gray-500">{{ $job->company->email }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Description Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-500">description</span>
                    <h3 class="text-lg font-semibold text-gray-800">Mô tả công việc</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="prose max-w-none text-gray-600 leading-relaxed bg-gray-50 rounded-xl p-5">
                    {!! nl2br(e($job->description ?? 'Chưa có mô tả chi tiết')) !!}
                </div>
            </div>
        </div>

        <!-- Skills Required Card -->
        @if($job->skills && $job->skills->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">code</span>
                        <h3 class="text-lg font-semibold text-gray-800">Kỹ năng yêu cầu</h3>
                        <span
                            class="ml-auto text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">{{ $job->skills->count() }}
                            kỹ năng</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($job->skills as $skill)
                            <span
                                class="px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 rounded-lg text-sm font-medium border border-indigo-200 shadow-sm">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Section -->
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500">analytics</span>
                <h3 class="text-lg font-semibold text-gray-800">Thống kê tuyển dụng</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <!-- Total Applications -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-500">group</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $stats['total_applications'] }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Tổng ứng viên</p>
                    <div class="mt-2 h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Avg Match Score -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-amber-50 group-hover:bg-amber-100 transition flex items-center justify-center">
                            <span class="material-symbols-outlined text-amber-500">star</span>
                        </div>
                        <span class="text-2xl font-bold text-amber-600">{{ $stats['avg_match_score'] }}%</span>
                    </div>
                    <p class="text-sm text-gray-500">Điểm trung bình</p>
                    <div class="mt-2 h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $stats['avg_match_score'] }}%"></div>
                    </div>
                </div>

                <!-- Pending Review -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-amber-50 group-hover:bg-amber-100 transition flex items-center justify-center">
                            <span class="material-symbols-outlined text-amber-500">pending</span>
                        </div>
                        <span class="text-2xl font-bold text-amber-600">{{ $stats['pending_review'] }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Chờ duyệt</p>
                    <div class="mt-2 h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full"
                            style="width: {{ $stats['total_applications'] > 0 ? ($stats['pending_review'] / $stats['total_applications']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- Shortlisted -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-green-50 group-hover:bg-green-100 transition flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-500">star</span>
                        </div>
                        <span class="text-2xl font-bold text-green-600">{{ $stats['shortlisted'] }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Tiềm năng</p>
                    <div class="mt-2 h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full"
                            style="width: {{ $stats['total_applications'] > 0 ? ($stats['shortlisted'] / $stats['total_applications']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- Hired -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-2">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-50 group-hover:bg-blue-100 transition flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-500">celebration</span>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $stats['hired'] }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Đã tuyển</p>
                    <div class="mt-2 h-1 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full"
                            style="width: {{ $stats['total_applications'] > 0 ? ($stats['hired'] / $stats['total_applications']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection