@php
    // Sửa lại PHP Map để lấy đủ dữ liệu Review (Quan trọng để UI biết CV nào đã được đánh giá)
    $mapped = $cvs->map(function ($cv) {
        $hasReview = $cv->review !== null;
        return [
            'id' => $cv->id,
            'name' => $cv->cv_name,
            'experience' => $cv->experience_years,
            'updated_at' => $cv->updated_at->format('d/m/Y'),
            'fromHistory' => $hasReview,
            'review_data' => $hasReview ? [
                'score' => floatval($cv->review->score),
                'summary' => $cv->review->summary,
                'strengths' => $cv->review->strengths ?? [],
                'weaknesses' => $cv->review->weaknesses ?? [],
                'suggestions' => $cv->review->suggestions ?? [],
            ] : null,
            'review_status' => $hasReview ? ($cv->review->is_valid ? ($cv->review->score >= 8 ? 'approved' : 'needs_improvement') : 'rejected_by_qa') : null,
            'validator_reason' => $hasReview ? $cv->review->validator_reason : null,
        ];
    })->values();
@endphp

@extends('layouts.candidate_layout')

@section('title', 'Đánh giá CV bằng AI | SmartCV')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@20..48,100..700,0..1" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 0.8s linear infinite;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>

    <main class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30 font-['Inter']" x-data="aiReviewApp()"
        x-init="init()">

        {{-- Flash Messages --}}
        @if($errors->any())
            <div
                class="fixed top-24 right-4 z-50 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-lg flex items-center gap-3 max-w-md animate-fade-in-down">
                <span class="material-symbols-outlined text-red-500">error</span>
                <p class="text-red-700 font-medium text-sm">{{ $errors->first() }}</p>
            </div>
        @endif

        {{-- Hero Section --}}
        <div class="relative overflow-hidden bg-white border-b border-gray-100">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5"></div>
            <div class="relative max-w-7xl mx-auto px-6 py-10 md:py-14">
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-full mb-4 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-blue-700 uppercase tracking-wide">AI Powered</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mb-2 font-['Manrope']">
                        Đánh giá CV bằng
                        <span
                            class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">AI</span>
                    </h1>
                    <p class="text-base text-gray-500 max-w-2xl mx-auto">
                        Phân tích thông minh, đánh giá khách quan — giúp hồ sơ của bạn nổi bật hơn bao giờ hết.
                    </p>
                </div>
            </div>
        </div>

        {{-- Main 2-Column Layout --}}
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- L CỘT TRÁI: Danh sách CV --}}
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden lg:sticky lg:top-24">
                        <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-bold text-gray-800 font-['Manrope']">Danh sách hồ sơ</h2>
                                    <p class="text-xs text-gray-400 mt-0.5">Chọn CV để xem đánh giá</p>
                                </div>
                                <div class="bg-blue-50 px-3 py-1 rounded-full flex items-center gap-1">
                                    <span class="text-sm font-bold text-blue-600" x-text="cvs.length"></span>
                                    <span class="text-xs font-medium text-blue-500">CV</span>
                                </div>
                            </div>
                        </div>

                        {{-- List CVs --}}
                        <div class="divide-y divide-gray-100 max-h-[500px] lg:max-h-[600px] overflow-y-auto">
                            <template x-for="(cv, index) in cvs" :key="cv.id">
                                <div class="p-4 cursor-pointer transition-all duration-200 hover:bg-blue-50/40 group"
                                    :class="selectedCvId === cv.id ? 'bg-blue-50/60 border-l-4 border-l-blue-500' : 'border-l-4 border-l-transparent'"
                                    @click="selectCV(cv.id)">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3 class="font-bold text-gray-800 text-sm group-hover:text-blue-700 transition-colors"
                                                    x-text="cv.name"></h3>
                                                <span x-show="cv.review_status" class="inline-block w-2 h-2 rounded-full"
                                                    :class="getStatusDotClass(cv.review_status)"></span>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mt-2">
                                                <span
                                                    class="flex items-center gap-1 font-medium bg-gray-100 px-2 py-0.5 rounded-md">
                                                    <span class="material-symbols-outlined text-[14px]">work</span>
                                                    <span x-text="cv.experience + ' năm'"></span>
                                                </span>

                                                <span x-show="cv.review_data"
                                                    class="flex items-center gap-1 text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded-md">
                                                    <span class="material-symbols-outlined text-[14px]">star</span>
                                                    <span
                                                        x-text="cv.review_data ? cv.review_data.score.toFixed(1) + '/10' : ''"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="ml-2">
                                            <button x-show="!cv.review_data && loadingCvId !== cv.id"
                                                class="px-3 py-1.5 text-xs font-semibold bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition shadow-sm"
                                                @click.stop="reviewCV(cv.id)">
                                                Đánh giá
                                            </button>
                                            <div x-show="loadingCvId === cv.id" class="px-3 py-1.5">
                                                <div
                                                    class="w-4 h-4 border-2 border-gray-200 border-t-blue-600 rounded-full animate-spin">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Empty State (No CVs) --}}
                            <div x-show="cvs.length === 0" class="p-8 text-center" x-cloak>
                                <div
                                    class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <span class="material-symbols-outlined text-gray-400 text-2xl">description</span>
                                </div>
                                <p class="text-gray-500 text-sm font-medium">Chưa có hồ sơ nào</p>
                                <a href="{{ route('candidate.cv.index') }}"
                                    class="mt-3 inline-block text-sm font-bold text-blue-600 hover:text-blue-800">Tải lên CV
                                    ngay →</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 👉 CỘT PHẢI: AI Review Panel --}}
                <div class="lg:col-span-8">
                    <div id="ai-review-panel"
                        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden lg:sticky lg:top-24 min-h-[500px]">

                        {{-- Panel Header --}}
                        <div class="p-5 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200/50 shrink-0">
                                    <span class="material-symbols-outlined text-white text-2xl">auto_awesome</span>
                                </div>
                                <div>
                                    <h2 class="font-extrabold text-gray-800 text-lg md:text-xl font-['Manrope']">AI Review
                                        Dashboard</h2>
                                    <p class="text-sm text-gray-500 font-medium">Báo cáo đánh giá năng lực chi tiết</p>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Content --}}
                        <div class="p-5 md:p-8">

                            {{-- 1. TRẠNG THÁI: Chưa chọn CV --}}
                            <div x-show="!selectedCvId" class="flex flex-col items-center justify-center h-64 text-center"
                                x-cloak>
                                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-blue-300 text-4xl">touch_app</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 mb-1">Chưa chọn hồ sơ</h3>
                                <p class="text-sm text-gray-500 max-w-sm">Vui lòng chọn một CV từ danh sách bên trái để xem
                                    hoặc bắt đầu đánh giá AI.</p>
                            </div>

                            {{-- 2. TRẠNG THÁI: Đã chọn CV --}}
                            <div x-show="selectedCvId" x-cloak>
                                <template x-if="selectedCvData">
                                    <div>

                                        {{-- 2A. TRẠNG THÁI: Đang phân tích (Loading) --}}
                                        <div x-show="loadingCvId === selectedCvId" class="py-20 text-center">
                                            <div class="inline-flex flex-col items-center gap-4">
                                                <div
                                                    class="w-14 h-14 border-4 border-blue-100 border-t-blue-600 rounded-full animate-spin">
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900">Hệ thống AI đang quét hồ
                                                        sơ...</h4>
                                                    <p class="text-gray-500 text-sm mt-1 max-w-xs mx-auto">Vui lòng chờ vài
                                                        giây, chúng tôi đang phân tích cấu trúc, từ khóa và kinh nghiệm của
                                                        bạn.</p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- 2B. TRẠNG THÁI: Chưa có đánh giá --}}
                                        <div x-show="!loadingCvId && !selectedCvData.review_data" class="py-16 text-center">
                                            <div
                                                class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-gray-100 border-dashed">
                                                <span
                                                    class="material-symbols-outlined text-gray-400 text-3xl">analytics</span>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Hồ sơ này chưa được đánh giá
                                            </h4>
                                            <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">Nhấn nút bên dưới để hệ
                                                thống Dual-Agent AI phân tích CV của bạn.</p>
                                            <button @click="reviewCV(selectedCvData.id)"
                                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all inline-flex items-center gap-2">
                                                <span class="material-symbols-outlined">psychology</span>
                                                Bắt đầu đánh giá ngay
                                            </button>
                                        </div>

                                        {{-- 2C. TRẠNG THÁI: Đã có đánh giá (Hiển thị kết quả) --}}
                                        <div x-show="!loadingCvId && selectedCvData.review_data"
                                            class="space-y-8 animate-fade-in-up">

                                            {{-- Khối Điểm số & Tóm tắt --}}
                                            <div
                                                class="flex flex-col md:flex-row gap-6 md:gap-8 items-center md:items-start pb-8 border-b border-gray-100">
                                                {{-- Vòng tròn điểm --}}
                                                <div class="text-center shrink-0">
                                                    <div class="relative w-32 h-32">
                                                        <svg class="w-full h-full transform -rotate-90">
                                                            <circle cx="64" cy="64" r="56" fill="none" stroke="#f1f5f9"
                                                                stroke-width="10"></circle>
                                                            <circle cx="64" cy="64" r="56" fill="none" stroke="currentColor"
                                                                stroke-width="10" stroke-linecap="round"
                                                                :stroke-dasharray="351.85"
                                                                :stroke-dashoffset="351.85 - ((selectedCvData.review_data?.score || 0) / 10) * 351.85"
                                                                :class="getScoreRingColor(selectedCvData.review_data?.score || 0)"
                                                                class="transition-all duration-1000 ease-out"></circle>
                                                        </svg>
                                                        <div
                                                            class="absolute inset-0 flex flex-col items-center justify-center">
                                                            <span class="text-3xl font-black text-gray-800 font-['Manrope']"
                                                                x-text="selectedCvData.review_data ? selectedCvData.review_data.score.toFixed(1) : '0'"></span>
                                                            <span class="text-xs font-bold text-gray-400">/10</span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide w-full"
                                                        :class="getStatusBadgeClass(selectedCvData.review_status)">
                                                        <span class="material-symbols-outlined text-[16px]"
                                                            x-text="getStatusIcon(selectedCvData.review_status)"></span>
                                                        <span x-text="getStatusText(selectedCvData.review_status)"></span>
                                                    </div>
                                                </div>

                                                {{-- Nội dung tóm tắt --}}
                                                <div class="flex-1 text-center md:text-left w-full">
                                                    <div
                                                        class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3">
                                                        <h3
                                                            class="text-xl font-bold text-gray-900 font-['Manrope'] flex items-center justify-center md:justify-start gap-2">
                                                            <span
                                                                class="material-symbols-outlined text-blue-500">summarize</span>
                                                            Nhận xét tổng quan
                                                        </h3>
                                                        <span x-show="selectedCvData.fromHistory"
                                                            class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">
                                                            <span
                                                                class="material-symbols-outlined text-[14px]">history</span>
                                                            Lịch sử
                                                        </span>
                                                    </div>

                                                    <p class="text-[15px] text-gray-600 leading-relaxed bg-gray-50/50 p-4 rounded-xl border border-gray-100"
                                                        x-text="selectedCvData.review_data?.summary"></p>

                                                    <div
                                                        class="mt-3 inline-flex items-center gap-2 text-xs font-medium text-blue-600 bg-blue-50 px-3 py-2 rounded-lg border border-blue-100 w-full md:w-auto text-left">
                                                        <span
                                                            class="material-symbols-outlined text-[16px] shrink-0">policy</span>
                                                        <span
                                                            x-text="selectedCvData.validator_reason || 'Đã được kiểm duyệt chất lượng bởi hệ thống AI.'"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Grid 3 Cột: Mạnh - Yếu - Đề xuất --}}
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                                {{-- Điểm sáng --}}
                                                <div
                                                    class="bg-emerald-50/40 rounded-2xl p-5 border border-emerald-100 shadow-sm">
                                                    <div
                                                        class="flex items-center gap-3 mb-4 border-b border-emerald-100/50 pb-3">
                                                        <div
                                                            class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 shadow-sm shrink-0">
                                                            <span
                                                                class="material-symbols-outlined text-[18px]">verified</span>
                                                        </div>
                                                        <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                                            Điểm sáng</h4>
                                                    </div>
                                                    <ul class="space-y-3">
                                                        <template x-for="s in selectedCvData.review_data?.strengths || []"
                                                            :key="s">
                                                            <li
                                                                class="flex items-start gap-2 text-[13px] text-gray-700 font-medium leading-relaxed">
                                                                <span class="text-emerald-500 shrink-0 mt-0.5">•</span>
                                                                <span x-text="s"></span>
                                                            </li>
                                                        </template>
                                                        <li x-show="!selectedCvData.review_data?.strengths?.length"
                                                            class="text-xs text-gray-400 italic">Chưa có dữ liệu</li>
                                                    </ul>
                                                </div>

                                                {{-- Rủi ro --}}
                                                <div class="bg-rose-50/40 rounded-2xl p-5 border border-rose-100 shadow-sm">
                                                    <div
                                                        class="flex items-center gap-3 mb-4 border-b border-rose-100/50 pb-3">
                                                        <div
                                                            class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600 shadow-sm shrink-0">
                                                            <span
                                                                class="material-symbols-outlined text-[18px]">warning</span>
                                                        </div>
                                                        <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                                            Điểm yếu</h4>
                                                    </div>
                                                    <ul class="space-y-3">
                                                        <template x-for="w in selectedCvData.review_data?.weaknesses || []"
                                                            :key="w">
                                                            <li
                                                                class="flex items-start gap-2 text-[13px] text-gray-700 font-medium leading-relaxed">
                                                                <span class="text-rose-500 shrink-0 mt-0.5">•</span>
                                                                <span x-text="w"></span>
                                                            </li>
                                                        </template>
                                                        <li x-show="!selectedCvData.review_data?.weaknesses?.length"
                                                            class="text-xs text-gray-400 italic">Không có rủi ro</li>
                                                    </ul>
                                                </div>

                                                {{-- Đề xuất --}}
                                                <div
                                                    class="bg-amber-50/40 rounded-2xl p-5 border border-amber-100 shadow-sm">
                                                    <div
                                                        class="flex items-center gap-3 mb-4 border-b border-amber-100/50 pb-3">
                                                        <div
                                                            class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600 shadow-sm shrink-0">
                                                            <span
                                                                class="material-symbols-outlined text-[18px]">lightbulb</span>
                                                        </div>
                                                        <h4 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
                                                            Cải thiện</h4>
                                                    </div>
                                                    <ul class="space-y-3">
                                                        <template x-for="s in selectedCvData.review_data?.suggestions || []"
                                                            :key="s">
                                                            <li
                                                                class="flex items-start gap-2 text-[13px] text-gray-700 font-medium leading-relaxed">
                                                                <span class="text-amber-500 shrink-0 mt-0.5">•</span>
                                                                <span x-text="s"></span>
                                                            </li>
                                                        </template>
                                                        <li x-show="!selectedCvData.review_data?.suggestions?.length"
                                                            class="text-xs text-gray-400 italic">Không có gợi ý</li>
                                                    </ul>
                                                </div>

                                            </div>

                                            {{-- Request New Review Button --}}
                                            <div class="pt-6 border-t border-gray-100 text-right">
                                                <button @click="reviewCV(selectedCvData.id, true)"
                                                    class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline flex items-center justify-end gap-1 w-full md:w-auto ml-auto">
                                                    <span class="material-symbols-outlined text-[18px]">refresh</span>
                                                    Yêu cầu đánh giá lại
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        function aiReviewApp() {
            return {
                cvs: [],
                selectedCvId: null,
                loadingCvId: null,

                init() {
                    // Dữ liệu đã được map sẵn qua biến $mapped từ PHP
                    this.cvs = @json($mapped);

                    // Nếu url có ?cv_id=... thì chọn sẵn, nếu không thì lấy cái đầu tiên
                    const urlParams = new URLSearchParams(window.location.search);
                    const defaultId = urlParams.get('cv_id');

                    if (defaultId) {
                        const exists = this.cvs.find(c => c.id == defaultId);
                        if (exists) this.selectedCvId = parseInt(defaultId);
                    } else if (this.cvs.length > 0) {
                        this.selectedCvId = this.cvs[0].id;
                    }
                },

                get selectedCvData() {
                    return this.cvs.find(cv => cv.id === this.selectedCvId);
                },

                selectCV(cvId) {
                    this.selectedCvId = cvId;

                    // Mobile Smooth Scroll (Chỉ cuộn khi ở màn hình nhỏ < 1024px)
                    if (window.innerWidth < 1024) {
                        setTimeout(() => {
                            const panel = document.getElementById('ai-review-panel');
                            if (panel) {
                                // Tính khoảng cách cuộn, trừ đi sticky header (khoảng 80px)
                                const y = panel.getBoundingClientRect().top + window.scrollY - 80;
                                window.scrollTo({ top: y, behavior: 'smooth' });
                            }
                        }, 50);
                    }
                },

                // Thêm tham số forceReload để bỏ qua Cache khi bấm "Đánh giá lại"
                async reviewCV(cvId, forceReload = false) {
                    const cv = this.cvs.find(c => c.id === cvId);
                    if (!cv) return;

                    this.selectCV(cvId);

                    // Nếu đã có review và KHÔNG bắt buộc tải lại -> Không gọi API
                    if (cv.review_data && !forceReload) {
                        return;
                    }

                    this.loadingCvId = cvId;

                    try {
                        const response = await fetch('{{ route("candidate.ai_review.process") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ cv_id: cvId })
                        });

                        const result = await response.json();

                        if (response.ok && result.review_data) {
                            cv.review_data = result.review_data;
                            cv.review_status = result.review_status;
                            cv.validator_reason = result.validator_reason;
                            cv.fromHistory = false; // Đánh dấu là kết quả mới nhất
                            cv.last_ai_score = result.review_data.score;
                        } else {
                            alert(result.message || 'Có lỗi xảy ra, vui lòng thử lại');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Lỗi kết nối. Hãy đảm bảo Server Python AI (Port 8002) đang chạy.');
                    } finally {
                        this.loadingCvId = null;
                    }
                },

                getScoreRingColor(score) {
                    if (score >= 8) return 'text-emerald-500';
                    if (score >= 5) return 'text-amber-500';
                    return 'text-rose-500';
                },

                getStatusBadgeClass(status) {
                    if (status === 'approved') return 'bg-emerald-100 text-emerald-700';
                    if (status === 'needs_improvement') return 'bg-amber-100 text-amber-700';
                    if (status === 'rejected_by_qa') return 'bg-rose-100 text-rose-700';
                    return 'bg-gray-100 text-gray-500';
                },

                getStatusDotClass(status) {
                    if (status === 'approved') return 'bg-emerald-500';
                    if (status === 'needs_improvement') return 'bg-amber-500';
                    if (status === 'rejected_by_qa') return 'bg-rose-500';
                    return 'bg-gray-400';
                },

                getStatusText(status) {
                    if (status === 'approved') return 'Đạt Chuẩn';
                    if (status === 'needs_improvement') return 'Cần Sửa';
                    if (status === 'rejected_by_qa') return 'Bị Từ Chối';
                    return '';
                },

                getStatusIcon(status) {
                    if (status === 'approved') return 'check_circle';
                    if (status === 'needs_improvement') return 'warning';
                    if (status === 'rejected_by_qa') return 'error';
                    return '';
                }
            }
        }
    </script>
@endsection