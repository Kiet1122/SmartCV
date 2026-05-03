@extends('layouts.candidate_layout')

@section('title', 'Lịch sử ứng tuyển | SmartCV')

@section('content')
    <main class="pt-24 pb-20 px-6 md:px-12 max-w-6xl mx-auto min-h-screen font-['Inter']">
        {{-- Header --}}
        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900 mb-2 font-['Manrope']">
                    Theo dõi đơn ứng tuyển
                </h1>
                <p class="text-gray-500 font-medium max-w-2xl">
                    Quản lý và theo dõi trạng thái các hồ sơ bạn đã gửi đến nhà tuyển dụng.
                </p>
            </div>
            <a href="{{ route('candidate.applications.recommendations') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-lg transition-all hover:-translate-y-0.5">
                Xem việc làm gợi ý
            </a>
        </header>

        {{-- Stats Summary --}}
        @if(!empty($applications) && count($applications) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Tổng đơn</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $applications->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Đã xem</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $applications->where('status', 'reviewed')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Chấp nhận</p>
                            <p class="text-2xl font-bold text-emerald-600">
                                {{ $applications->where('status', 'accepted')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Từ chối</p>
                            <p class="text-2xl font-bold text-rose-600">
                                {{ $applications->where('status', 'rejected')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Applications List --}}
        <div class="grid grid-cols-1 gap-5">
            @forelse($applications ?? [] as $app)
                @php
                    $statusConfig = [
                        'pending' => [
                            'bg' => 'bg-amber-50',
                            'text' => 'text-amber-700',
                            'icon' => 'schedule',
                            'label' => 'Chờ xử lý',
                            'badge' => 'bg-amber-100 text-amber-700'
                        ],
                        'reviewed' => [
                            'bg' => 'bg-blue-50',
                            'text' => 'text-blue-700',
                            'icon' => 'visibility',
                            'label' => 'Đã xem CV',
                            'badge' => 'bg-blue-100 text-blue-700'
                        ],
                        'accepted' => [
                            'bg' => 'bg-emerald-50',
                            'text' => 'text-emerald-700',
                            'icon' => 'check_circle',
                            'label' => 'Được chấp nhận',
                            'badge' => 'bg-emerald-100 text-emerald-700'
                        ],
                        'rejected' => [
                            'bg' => 'bg-rose-50',
                            'text' => 'text-rose-700',
                            'icon' => 'cancel',
                            'label' => 'Bị từ chối',
                            'badge' => 'bg-rose-100 text-rose-700'
                        ],
                    ];
                    $currentStatus = $statusConfig[$app->status ?? 'pending'];
                @endphp

                <div
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="p-6 flex flex-col md:flex-row gap-6">
                        {{-- Company Logo --}}
                        <div
                            class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if(!empty($app->jobPost->company->logo_url))
                                <img src="{{ asset('storage/' . $app->jobPost->company->logo_url) }}" alt="Logo công ty"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-gray-300 text-3xl">{{ $app->jobPost->company->company_name }}</span>
                            @endif
                        </div>

                        {{-- Main Content --}}
                        <div class="flex-1">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-3 mb-3">
                                <div>
                                    <h3
                                        class="text-lg font-bold text-gray-900 font-['Manrope'] hover:text-blue-600 transition-colors">
                                        <a href="{{ route('public.jobs.show', $app->jobPost->id) }}">
                                            {{ $app->jobPost->title ?? 'Công việc không xác định' }}
                                        </a>
                                    </h3>
                                    <p class="text-sm font-medium text-blue-600">
                                        {{ $app->jobPost->company->company_name ?? 'Công ty bảo mật' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }}">
                                        <span class="material-symbols-outlined text-[16px]">{{ $currentStatus['icon'] }}</span>
                                        {{ $currentStatus['label'] }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 text-xs font-medium text-gray-500 mt-4">
                                <span class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-full">
                                    Nộp lúc: {{ $app->created_at ? $app->created_at->format('H:i - d/m/Y') : 'Không rõ' }}
                                </span>

                                <span class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-full">
                                    Hồ sơ:
                                    <a href="{{ route('candidate.cv.show', $app->cv_id) }}"
                                        class="text-blue-600 hover:text-blue-700 hover:underline truncate max-w-[150px] flex items-center gap-1">
                                        {{ $app->cv->cv_name ?? 'Bản lưu nháp' }}
                                    </a>
                                </span>

                                @if(!empty($app->match_score))
                                    <span class="flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-full">
                                        Độ phù hợp: {{ number_format($app->match_score, 1) }}%
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <div class="flex flex-row md:flex-col gap-2 justify-end">
                            <a href="{{ route('public.jobs.show', $app->jobPost->id) }}"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 bg-gray-50 hover:bg-blue-50 rounded-xl transition-all text-center">
                                Xem chi tiết
                            </a>
                            <button onclick="window.print()"
                                class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all">
                                In đơn
                            </button>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    @if($app->status !== 'pending')
                        <div class="h-1 bg-gray-100">
                            <div class="h-full transition-all duration-500 rounded-full"
                                style="width: {{ $app->status == 'accepted' ? '100' : ($app->status == 'reviewed' ? '50' : '100') }}%"
                                :class="{
                                                 'bg-emerald-500': '{{ $app->status }}' === 'accepted',
                                                 'bg-blue-500': '{{ $app->status }}' === 'reviewed',
                                                 'bg-rose-500': '{{ $app->status }}' === 'rejected'
                                             }"></div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-200 border-dashed">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có lịch sử ứng tuyển</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        Bạn chưa gửi hồ sơ cho bất kỳ vị trí nào. Hãy để AI giúp bạn tìm kiếm công việc phù hợp nhất.
                    </p>
                    <a href="{{ route('candidate.applications.recommendations') }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-lg">
                        Khám phá việc làm ngay
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        @if(isset($applications) && $applications->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $applications->links() }}
            </div>
        @endif
    </main>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .group:hover .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .group {
            animation: fadeInUp 0.4s ease forwards;
        }
    </style>
@endsection