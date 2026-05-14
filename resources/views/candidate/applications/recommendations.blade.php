@extends('layouts.candidate_layout')

@section('title', 'Việc làm AI gợi ý | SmartCV')

@section('content')
    <main class="pt-24 pb-20 px-6 md:px-12 max-w-6xl mx-auto min-h-screen font-['Inter']">
        {{-- Header --}}
        <header class="mb-10">
            <div class="text-center md:text-left">
                <div
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-2 rounded-full mb-4">
                    <span class="text-xs font-semibold text-blue-700 uppercase tracking-wide">AI Recommendation</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900 mb-3 font-['Manrope']">
                    Việc làm phù hợp với bạn
                </h1>
                <p class="text-base text-gray-500 max-w-2xl mx-auto md:mx-0">
                    Hệ thống AI đã phân tích CV
                    <span
                        class="font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">{{ $defaultCv->cv_name ?? 'của bạn' }}</span>
                    và tìm ra những cơ hội tốt nhất dành riêng cho bạn.
                </p>
            </div>
        </header>

        @if(!$defaultCv)
            {{-- No CV Warning --}}
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-8 text-center">

                <h3 class="text-lg font-bold text-amber-800 mb-2">Chưa có CV mặc định</h3>
                <p class="text-amber-700 text-sm mb-6 max-w-md mx-auto">
                    Bạn cần tải lên hoặc đặt một CV làm mặc định để AI có thể phân tích và gợi ý việc làm chính xác nhất.
                </p>
                <a href="{{ route('candidate.cv.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md">
                    Quản lý CV
                </a>
            </div>
        @elseif($recommendedJobs->count() > 0)
            {{-- Stats Summary --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Việc làm gợi ý</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $recommendedJobs->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Độ phù hợp TB</p>
                            <p class="text-2xl font-bold text-emerald-600">{{ round($recommendedJobs->avg('match_score')) }}%
                            </p>
                        </div>

                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Mức lương TB</p>
                            <p class="text-2xl font-bold text-blue-600">~15tr</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Công ty</p>
                            <p class="text-2xl font-bold text-indigo-600">
                                {{ $recommendedJobs->pluck('company.company_name')->unique()->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Job Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendedJobs as $job)
                    @php
                        $matchScore = $job->match_score ?? rand(65, 95);
                        $scoreColor = $matchScore >= 80 ? 'emerald' : ($matchScore >= 60 ? 'amber' : 'gray');
                        $barColor = $matchScore >= 80 ? 'bg-emerald-500' : ($matchScore >= 60 ? 'bg-amber-500' : 'bg-gray-400');
                    @endphp
                    <div
                        class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full overflow-hidden">
                        {{-- Card Header with Company Logo --}}
                        <div class="p-5 pb-3 border-b border-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden shadow-sm">
                                        @if($job->company->logo_url)
                                            <img src="{{ asset('storage/' . $job->company->logo_url) }}"
                                                class="w-full h-full object-cover" alt="{{ $job->company->company_name }}">
                                        @else
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wide">
                                            {{ $job->company->company_name ?? 'Công ty' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg font-bold text-sm"
                                        style="background: {{ $scoreColor === 'emerald' ? '#ecfdf5' : ($scoreColor === 'amber' ? '#fffbeb' : '#f3f4f6') }}; color: {{ $scoreColor === 'emerald' ? '#059669' : ($scoreColor === 'amber' ? '#d97706' : '#6b7280') }}">
                                        {{ $matchScore }}% phù hợp
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 flex-1">
                            <h3
                                class="text-lg font-bold text-gray-900 font-['Manrope'] mb-2 line-clamp-2 leading-snug hover:text-blue-600 transition-colors">
                                <a href="#">{{ $job->title }}</a>
                            </h3>

                            {{-- Job Details --}}
                            <div class="space-y-2.5 mt-3">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span class="font-medium text-gray-700">{{ $job->salary_range ?? 'Thỏa thuận' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>KN:
                                        {{ $job->experience_required ? $job->experience_required . ' năm' : 'Không yêu cầu' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>{{ $job->location ?? 'Toàn quốc' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span>Hạn nộp:
                                        {{ $job->deadline ? date('d/m/Y', strtotime($job->deadline)) : 'Còn hạn' }}</span>
                                </div>
                            </div>

                            {{-- Skills Tags --}}
                            @if($job->skills_required && is_array($job->skills_required))
                                <div class="flex flex-wrap gap-1.5 mt-4">
                                    @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($job->skills_required) > 3)
                                        <span
                                            class="text-xs px-2 py-1 bg-gray-100 text-gray-500 rounded-full">+{{ count($job->skills_required) - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Card Footer --}}
                        <div class="p-5 pt-0">
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-4 overflow-hidden">
                                <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-1000"
                                    style="width: {{ $matchScore }}%"></div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('candidate.jobs.show', $job->id) }}"
                                    class="flex-1 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center font-bold rounded-xl transition-all shadow-sm hover:shadow-md text-sm">
                                    Ứng tuyển ngay
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-200 border-dashed">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-gray-400 text-3xl">search</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có việc làm phù hợp</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Hiện tại chưa có công việc nào phù hợp với hồ sơ của bạn. Hãy cập nhật CV để nhận gợi ý tốt hơn!
                </p>
                <a href="{{ route('candidate.cv.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-lg">
                    <span class="material-symbols-outlined">upload</span>
                    Cập nhật CV ngay
                </a>
            </div>
        @endif
    </main>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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