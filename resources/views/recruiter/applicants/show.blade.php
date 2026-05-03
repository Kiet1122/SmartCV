@extends('layouts.recruiter_layout')

@section('title', 'Hồ sơ ứng viên | The Curator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Navigation -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Quay lại danh sách ứng viên</span>
            </a>
        </div>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-white text-2xl">person</span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $applicant->candidate->user->name }}</h1>
                    <p class="text-gray-500 mt-1">Ứng tuyển: <strong
                            class="text-gray-700">{{ $applicant->jobPost->title }}</strong></p>
                </div>
            </div>

            <!-- Match Score Circle -->
            <div class="text-center">
                <div class="relative w-24 h-24 mx-auto">
                    <svg class="w-24 h-24 transform -rotate-90">
                        <circle class="text-gray-100" cx="48" cy="48" fill="transparent" r="42" stroke="currentColor"
                            stroke-width="6"></circle>
                        <circle class="transition-all duration-1000 ease-out" cx="48" cy="48" fill="transparent" r="42"
                            stroke="currentColor" stroke-width="6" stroke-linecap="round"
                            :stroke="getScoreColor({{ $applicant->match_score }})" stroke-dasharray="263.89"
                            stroke-dashoffset="{{ 263.89 - (($applicant->match_score ?? 0) / 100) * 263.89 }}">
                        </circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xl font-bold text-gray-900">{{ $applicant->match_score ?? 0 }}<span
                                class="text-sm">%</span></span>
                        <span class="text-xs text-gray-400">Match Score</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - CV Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50/30">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">description</span>
                            <h3 class="font-semibold text-gray-800">Thông tin CV</h3>
                        </div>
                    </div>

                    <div class="p-5 space-y-4">
                        <!-- Job Position -->
                        <div>
                            <label class="text-xs text-gray-400 uppercase tracking-wider">Vị trí ứng tuyển</label>
                            <p class="font-semibold text-gray-800 mt-1">{{ $applicant->jobPost->title }}</p>
                        </div>

                        <!-- Experience -->
                        <div>
                            <label class="text-xs text-gray-400 uppercase tracking-wider">Kinh nghiệm</label>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="material-symbols-outlined text-amber-500 text-base">timeline</span>
                                <span class="font-semibold text-gray-800">{{ $applicant->cv->experience_years ?? 0 }}
                                    năm</span>
                            </div>
                        </div>

                        <!-- Applied Date -->
                        <div>
                            <label class="text-xs text-gray-400 uppercase tracking-wider">Ngày nộp</label>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="material-symbols-outlined text-gray-400 text-base">calendar_today</span>
                                <span class="text-gray-700">{{ $applicant->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <hr class="my-2 border-gray-100">

                        <!-- Skills -->
                        @if($applicant->cv->skills && $applicant->cv->skills->count() > 0)
                            <div>
                                <label class="text-xs text-gray-400 uppercase tracking-wider">Kỹ năng</label>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($applicant->cv->skills->take(5) as $skill)
                                        <span
                                            class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $skill->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Raw Text Summary -->
                        <div>
                            <label class="text-xs text-gray-400 uppercase tracking-wider">Nội dung tóm tắt</label>
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                {{ $applicant->cv->raw_text ? Str::limit($applicant->cv->raw_text, 200) : 'Chưa có dữ liệu' }}
                            </p>
                        </div>

                        <!-- View CV Button -->
                        <a href="{{ asset('storage/' . $applicant->cv->file_url) }}" target="_blank"
                            class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium text-sm">
                            <span class="material-symbols-outlined text-base">open_in_new</span>
                            Xem CV gốc
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - AI Analysis -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50/30">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">psychology</span>
                            <h3 class="font-semibold text-gray-800">Đánh giá chi tiết từ AI</h3>
                        </div>
                    </div>

                    <div class="p-5">
                        @if($applicant->cv->review)
                            <!-- Summary -->
                            <div class="bg-blue-50 rounded-xl p-5 mb-6 border-l-4 border-blue-500">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-blue-500">auto_awesome</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-1">Tóm tắt chung</h4>
                                        <p class="text-gray-600 leading-relaxed">{{ $applicant->cv->review->summary }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Strengths & Weaknesses Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <!-- Strengths -->
                                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-green-600 text-base">trending_up</span>
                                        </div>
                                        <h4 class="font-semibold text-gray-800">Điểm mạnh</h4>
                                    </div>
                                    <ul class="space-y-2">
                                        @forelse($applicant->cv->review->strengths ?? [] as $strength)
                                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                                <span class="text-green-500 text-lg leading-5">•</span>
                                                <span>{{ $strength }}</span>
                                            </li>
                                        @empty
                                            <li class="text-gray-400 italic text-sm">Chưa có dữ liệu</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <!-- Weaknesses -->
                                <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-red-600 text-base">warning</span>
                                        </div>
                                        <h4 class="font-semibold text-gray-800">Điểm cần cải thiện</h4>
                                    </div>
                                    <ul class="space-y-2">
                                        @forelse($applicant->cv->review->weaknesses ?? [] as $weakness)
                                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                                <span class="text-red-500 text-lg leading-5">•</span>
                                                <span>{{ $weakness }}</span>
                                            </li>
                                        @empty
                                            <li class="text-gray-400 italic text-sm">Chưa có dữ liệu</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            <!-- Suggestions -->
                            <div class="bg-amber-50 rounded-xl p-5 border border-amber-100">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-amber-600">lightbulb</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-2">Gợi ý cho nhà tuyển dụng</h4>
                                        <p class="text-gray-600 leading-relaxed">
                                            @php
                                                $suggestions = $applicant->cv->review->suggestions ?? [];
                                                if (is_array($suggestions)) {
                                                    echo implode(' ', array_map(function ($s) {
                                                        return '• ' . $s;
                                                    }, $suggestions));
                                                } else {
                                                    echo $suggestions ?? 'Chưa có đề xuất cụ thể';
                                                }
                                            @endphp
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- QA Validation Badge -->
                            @if($applicant->cv->review->is_valid)
                                <div class="mt-5 flex items-center justify-center gap-2 text-xs text-gray-400">
                                    <span class="material-symbols-outlined text-gray-400 text-sm">verified</span>
                                    <span>Đã được kiểm duyệt bởi hệ thống Dual-Agent</span>
                                </div>
                            @endif

                        @else
                            <div class="text-center py-8">
                                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-gray-400 text-3xl">psychology</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Chưa có đánh giá AI</h3>
                                <p class="text-gray-500">Hệ thống chưa phân tích chi tiết cho CV này</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mt-6">
                    <button
                        class="flex items-center gap-2 px-5 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors">
                        <span class="material-symbols-outlined text-base">check_circle</span>
                        Duyệt hồ sơ
                    </button>
                    <button
                        class="flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white rounded-xl hover:bg-amber-600 transition-colors">
                        <span class="material-symbols-outlined text-base">star</span>
                        Lưu vào danh sách tiềm năng
                    </button>
                    <button
                        class="flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors">
                        <span class="material-symbols-outlined text-base">close</span>
                        Từ chối
                    </button>
                    <button
                        class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors ml-auto">
                        <span class="material-symbols-outlined text-base">download</span>
                        Tải CV
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for SVG circle animation -->
    <script>
        function getScoreColor(score) {
            if (score >= 75) return '#10b981';
            if (score >= 50) return '#f59e0b';
            return '#ef4444';
        }
    </script>
@endsection