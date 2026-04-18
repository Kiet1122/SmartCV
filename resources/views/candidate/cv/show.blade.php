@extends('layouts.candidate_layout')

@section('title', 'Chi tiết CV - SmartCV')

@section('content')
    <main class="max-w-7xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('candidate.cv.index') }}" class="text-gray-500 hover:text-blue-600 transition">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </a>
                        <h1 class="text-3xl font-extrabold font-headline tracking-[-0.03em] text-on-surface">
                            Chi tiết CV
                        </h1>
                    </div>
                    <p class="text-on-surface-variant max-w-2xl leading-relaxed">
                        Xem thông tin chi tiết và dữ liệu phân tích từ AI của CV
                        <span class="font-semibold text-blue-600">{{ $cv->cv_name ?? basename($cv->file_url) }}</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ asset('storage/' . $cv->file_url) }}" target="_blank"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition flex items-center gap-2">
                        <i class="fas fa-eye"></i> Xem PDF gốc
                    </a>
                </div>
            </div>
        </div>

        @php
            $parsedData = is_string($cv->parsed_data) ? json_decode($cv->parsed_data, true) : ($cv->parsed_data ?? []);
        @endphp

        @if(!$cv->parsed_data)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-r-xl p-6 mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                    <div>
                        <h3 class="font-semibold text-yellow-800">CV đang được xử lý</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Hệ thống AI đang phân tích CV của bạn. Vui lòng quay lại sau vài phút.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 mb-8 text-white">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold mb-1">Điểm phù hợp với thị trường</h2>
                        <p class="text-blue-100 text-sm">Dựa trên phân tích kỹ năng và kinh nghiệm của bạn</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold">{{ $parsedData['experience_years'] ?? 0 }} năm</div>
                            <div class="text-xs text-blue-200">Kinh nghiệm</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold">{{ count($parsedData['skills'] ?? []) }}</div>
                            <div class="text-xs text-blue-200">Kỹ năng</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold">{{ count($parsedData['projects'] ?? []) }}</div>
                            <div class="text-xs text-blue-200">Dự án</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-user-circle text-blue-500"></i> Thông tin cá nhân
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-semibold">Họ và tên</label>
                                    <p class="text-gray-900 font-medium mt-1">
                                        {{ $parsedData['personal_info']['name'] ?? 'Chưa có' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-semibold">Email</label>
                                    <p class="text-gray-900 mt-1">{{ $parsedData['personal_info']['email'] ?? 'Chưa có' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-semibold">Số điện thoại</label>
                                    <p class="text-gray-900 mt-1">{{ $parsedData['personal_info']['phone'] ?? 'Chưa có' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-semibold">Địa chỉ</label>
                                    <p class="text-gray-900 mt-1">{{ $parsedData['personal_info']['address'] ?? 'Chưa có' }}</p>
                                </div>
                                @if(!empty($parsedData['personal_info']['github']))
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-semibold">GitHub</label>
                                    <p class="text-blue-600 mt-1 truncate hover:underline">
                                        <a href="{{ $parsedData['personal_info']['github'] }}" target="_blank">
                                            {{ str_replace(['https://', 'http://'], '', $parsedData['personal_info']['github']) }}
                                        </a>
                                    </p>
                                </div>
                                @endif
                                @if(!empty($parsedData['personal_info']['portfolio']))
                                <div>
                                    <label class="text-xs text-gray-500 uppercase font-semibold">Portfolio / Website</label>
                                    <p class="text-blue-600 mt-1 truncate hover:underline">
                                        <a href="{{ $parsedData['personal_info']['portfolio'] }}" target="_blank">Mở liên kết</a>
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(!empty($parsedData['summary']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-quote-left text-blue-500"></i> Giới thiệu bản thân
                                </h2>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-700 italic leading-relaxed">"{{ $parsedData['summary'] }}"</p>
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['skills']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div
                                class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-code text-blue-500"></i> Kỹ năng chuyên môn
                                </h2>
                                <span
                                    class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ count($parsedData['skills']) }}
                                    kỹ năng</span>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($parsedData['skills'] as $skill)
                                        <span
                                            class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium border border-indigo-100">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['soft_skills']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div
                                class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-users text-teal-500"></i> Kỹ năng mềm
                                </h2>
                                <span
                                    class="text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded-full">{{ count($parsedData['soft_skills']) }}
                                    kỹ năng</span>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($parsedData['soft_skills'] as $skill)
                                        <span
                                            class="px-3 py-1.5 bg-teal-50 text-teal-700 rounded-full text-sm font-medium border border-teal-100">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['projects']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-laptop-code text-blue-500"></i> Dự án đã thực hiện
                                </h2>
                            </div>
                            <div class="p-6 space-y-6">
                                @foreach($parsedData['projects'] as $index => $project)
                                    <div class="border-b border-gray-100 last:border-0 pb-4 last:pb-0">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-base font-bold text-gray-800">{{ $project['name'] }}</h3>
                                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $project['description'] }}</p>
                                                @if(!empty($project['technologies']))
                                                    <div class="flex flex-wrap gap-1.5 mt-3">
                                                        @foreach($project['technologies'] as $tech)
                                                            <span
                                                                class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $tech }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['work_experience']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-briefcase text-blue-500"></i> Kinh nghiệm làm việc
                                </h2>
                            </div>
                            <div class="p-6 space-y-4">
                                @foreach($parsedData['work_experience'] as $job)
                                    <div class="relative pl-4 border-l-2 border-blue-200 pb-4 last:pb-0">
                                        <div class="absolute w-2 h-2 bg-blue-500 rounded-full -left-[5px] top-1.5"></div>
                                        <h3 class="text-base font-bold text-gray-800">{{ $job['job_title'] ?? 'Vị trí không xác định' }}
                                        </h3>
                                        <p class="text-sm font-medium text-blue-600">{{ $job['company'] ?? 'Công ty không xác định' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $job['start_month'] ?? '?' }}/{{ $job['start_year'] ?? '?' }} -
                                            {{ $job['is_current'] ? 'Hiện tại' : (($job['end_month'] ?? '?') . '/' . ($job['end_year'] ?? '?')) }}
                                        </p>
                                        @if(!empty($job['description']))
                                            <p class="text-sm text-gray-600 mt-2">{{ $job['description'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['education']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-graduation-cap text-blue-500"></i> Học vấn
                                </h2>
                            </div>
                            <div class="p-6 space-y-3">
                                @foreach($parsedData['education'] as $edu)
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-university text-blue-400 mt-1"></i>
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $edu['degree'] ?? 'Bằng cấp' }}</h3>
                                            <p class="text-sm text-gray-600">{{ $edu['institution'] ?? 'Trường' }}</p>
                                            <p class="text-xs text-gray-500">{{ $edu['start_year'] ?? '?' }} -
                                                {{ $edu['end_year'] ?? '?' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    @if(!empty($parsedData['achievements']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                            <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-trophy text-yellow-500"></i> Thành tích
                                </h2>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-2">
                                    @foreach($parsedData['achievements'] as $achievement)
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <i class="fas fa-check-circle text-green-500 text-xs mt-0.5"></i>
                                            <span>{{ $achievement }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['certifications']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-certificate text-purple-500"></i> Chứng chỉ
                                </h2>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-2">
                                    @foreach($parsedData['certifications'] as $cert)
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <i class="fas fa-award text-purple-500 text-xs mt-0.5"></i>
                                            <span>{{ $cert }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(!empty($parsedData['languages']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-white border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-language text-green-500"></i> Ngôn ngữ
                                </h2>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-2">
                                    @foreach($parsedData['languages'] as $lang)
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <i class="fas fa-comment-dots text-green-500 text-xs mt-0.5"></i>
                                            <span>{{ $lang }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-5 border border-gray-200">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-500"></i> Thông tin CV
                        </h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex justify-between">
                                <span>Tên file:</span>
                                <span class="font-medium truncate max-w-[150px]" title="{{ basename($cv->file_url) }}">{{ basename($cv->file_url) }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Ngày tải lên:</span>
                                <span>{{ $cv->created_at ? $cv->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
                            </li>
                            @if($cv->is_default)
                                <li class="flex justify-between">
                                    <span>Trạng thái:</span>
                                    <span class="text-blue-600 font-medium"><i class="fas fa-star"></i> Mặc định</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('candidate.cv.index') }}"
                            class="flex-1 text-center px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition font-medium">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <style>
        @media print {
            .bg-gradient-to-r,
            .gap-3>a:not(:first-child),
            button,
            .sticky {
                display: none !important;
            }
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .shadow-sm {
                box-shadow: none !important;
            }
            .border {
                border: 1px solid #e5e7eb !important;
            }
        }
    </style>
@endsection