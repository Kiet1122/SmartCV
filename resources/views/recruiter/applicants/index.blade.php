@extends('layouts.recruiter_layout')

@section('title', 'Phân tích ứng viên | The Curator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">analytics</span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Phân tích ứng viên theo vị trí</h1>
                    <p class="text-gray-500 mt-1">Tổng quan số lượng ứng viên cho từng tin tuyển dụng</p>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng số tin tuyển dụng</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $jobs->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-500">work</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng số ứng viên</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $jobs->sum('applications_count') }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-emerald-500">group</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Trung bình ứng viên/tin</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $jobs->avg('applications_count') ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-purple-500">bar_chart</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($jobs as $job)
                <div
                    class="group bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 overflow-hidden">
                    <!-- Card Header -->
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1">{{ $job->title }}</h3>
                                <div class="flex items-center gap-2 mt-2">
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
                                </div>
                            </div>
                            <!-- Applicant Count Circle -->
                            <div class="text-center">
                                <div class="w-16 h-16 rounded-full bg-blue-50 flex flex-col items-center justify-center">
                                    <span class="text-2xl font-bold text-blue-600">{{ $job->applications_count }}</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">ứng viên</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5">
                        <div class="space-y-3">
                            <!-- Experience -->
                            @if($job->experience_required)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <span class="material-symbols-outlined text-gray-400 text-base">timeline</span>
                                    <span>Kinh nghiệm: <strong>{{ $job->experience_required }} năm</strong></span>
                                </div>
                            @endif

                            <!-- Salary -->
                            @if($job->salary_range)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <span class="material-symbols-outlined text-gray-400 text-base">payments</span>
                                    <span>Mức lương: <strong>{{ $job->salary_range }}</strong></span>
                                </div>
                            @endif

                            <!-- Posted Date -->
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="material-symbols-outlined text-gray-400 text-base">calendar_today</span>
                                <span>Đăng ngày: <strong>{{ $job->created_at->format('d/m/Y') }}</strong></span>
                            </div>

                            <!-- Skills -->
                            @if($job->skills && $job->skills->count() > 0)
                                <div class="flex flex-wrap gap-1.5 pt-2">
                                    @foreach($job->skills->take(3) as $skill)
                                        <span
                                            class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $skill->name }}</span>
                                    @endforeach
                                    @if($job->skills->count() > 3)
                                        <span
                                            class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">+{{ $job->skills->count() - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="px-5 py-3 bg-gray-50 border-t border-gray-100">
                        <a href="{{ route('recruiter.applicants.listByJob', $job->id) }}"
                            class="inline-flex items-center justify-between w-full text-blue-600 font-medium hover:text-blue-700 transition-colors">
                            <span>Xem danh sách ứng viên</span>
                            <span
                                class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($jobs->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-gray-400 text-3xl">work_off</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa có tin tuyển dụng nào</h3>
                <p class="text-gray-500 mb-4">Hãy đăng tin tuyển dụng để bắt đầu nhận hồ sơ ứng viên</p>
                <a href="{{ route('recruiter.jobs.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition">
                    <span class="material-symbols-outlined text-base">add</span>
                    Đăng tin ngay
                </a>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection