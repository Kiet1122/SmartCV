@extends('layouts.recruiter_layout')

@section('title', 'Chi tiết ứng viên | The Curator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('recruiter.applicants.listByJob', $applicant->job_post_id) }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Quay lại danh sách ứng viên</span>
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-xl p-4 flex items-center gap-3">
                <span class="material-symbols-outlined text-red-500">error</span>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-xl p-4 flex items-center gap-3">
                <span class="material-symbols-outlined text-green-500">check_circle</span>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Candidate Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">

                    <!-- Card Header with Cover -->
                    <div class="relative h-24 bg-gradient-to-r from-blue-500 to-indigo-600">
                        <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                            <div class="w-24 h-24 rounded-full bg-white p-1 shadow-lg">
                                <div
                                    class="w-full h-full rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($applicant->candidate->user->name, 0, 2)) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="pt-16 pb-6 px-6 text-center">
                        <h2 class="text-xl font-bold text-gray-900">{{ $applicant->candidate->user->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ $applicant->candidate->user->email }}</p>
                        <p class="text-blue-600 text-sm font-medium mt-2">{{ $applicant->jobPost->title }}</p>

                        <!-- Match Score -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500 text-sm">Điểm tương thích AI</span>
                                @php
                                    $score = $applicant->match_score ?? 0;
                                    $scoreColor = $score >= 70 ? 'text-green-600' : ($score >= 40 ? 'text-amber-600' : 'text-red-600');
                                    $scoreBg = $score >= 70 ? 'bg-green-100' : ($score >= 40 ? 'bg-amber-100' : 'bg-red-100');
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $scoreBg }} {{ $scoreColor }}">
                                    {{ $score }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="rounded-full h-2 transition-all duration-500 {{ $score >= 70 ? 'bg-green-500' : ($score >= 40 ? 'bg-amber-500' : 'bg-red-500') }}"
                                    style="width: {{ $score }}%"></div>
                            </div>
                        </div>

                        <!-- Quick Info -->
                        <div class="mt-6 space-y-3 text-left">
                            <div class="flex items-center gap-3 text-gray-600">
                                <span class="material-symbols-outlined text-gray-400 text-base">work</span>
                                <span>Kinh nghiệm: <strong>{{ $applicant->cv->experience_years ?? 0 }} năm</strong></span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-600">
                                <span class="material-symbols-outlined text-gray-400 text-base">calendar_today</span>
                                <span>Ngày ứng tuyển:
                                    <strong>{{ $applicant->created_at->format('d/m/Y H:i') }}</strong></span>
                            </div>
                            <div class="flex items-center gap-3 text-gray-600">
                                <span class="material-symbols-outlined text-gray-400 text-base">pending</span>
                                <span>Trạng thái:
                                    <strong
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs
                                            {{ $applicant->status == 'accepted' ? 'bg-green-100 text-green-700' : ($applicant->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                        {{ $applicant->status == 'accepted' ? 'Đã duyệt' : ($applicant->status == 'rejected' ? 'Từ chối' : 'Chờ duyệt') }}
                                    </strong>
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-2">
                            <a href="{{ asset('storage/' . $applicant->cv->file_url) }}" target="_blank"
                                class="flex items-center justify-center gap-2 w-full py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                Xem CV trực tuyến
                            </a>
                            <a href="{{ route('recruiter.applicants.download_cv', $applicant->id) }}"
                                class="flex items-center justify-center gap-2 w-full py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                                <span class="material-symbols-outlined text-base">download</span>
                                Tải CV xuống
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Detailed Information -->
            <div class="lg:col-span-2 space-y-6">

                <!-- AI Review Section -->
                @if($applicant->cv->review)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-600">psychology</span>
                                <h3 class="font-semibold text-gray-800">Đánh giá chi tiết từ AI</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Summary -->
                            <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-500">
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ $applicant->cv->review->summary ?? 'Chưa có đánh giá tổng quan.' }}</p>
                            </div>

                            <!-- Strengths & Weaknesses Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="material-symbols-outlined text-green-600">trending_up</span>
                                        <h4 class="font-semibold text-gray-800">Điểm mạnh</h4>
                                    </div>
                                    <ul class="space-y-1.5">
                                        @foreach($applicant->cv->review->strengths ?? [] as $strength)
                                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                                <span class="text-green-500 text-lg leading-5">•</span>
                                                <span>{{ $strength }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="material-symbols-outlined text-red-600">warning</span>
                                        <h4 class="font-semibold text-gray-800">Điểm cần cải thiện</h4>
                                    </div>
                                    <ul class="space-y-1.5">
                                        @foreach($applicant->cv->review->weaknesses ?? [] as $weakness)
                                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                                <span class="text-red-500 text-lg leading-5">•</span>
                                                <span>{{ $weakness }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            @if($applicant->cv->review->suggestions)
                                <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="material-symbols-outlined text-amber-600">lightbulb</span>
                                        <h4 class="font-semibold text-gray-800">Gợi ý cải thiện</h4>
                                    </div>
                                    <ul class="space-y-1.5">
                                        @foreach($applicant->cv->review->suggestions as $suggestion)
                                            <li class="flex items-start gap-2 text-sm text-gray-600">
                                                <span class="text-amber-500 text-lg leading-5">•</span>
                                                <span>{{ $suggestion }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- CHI TIẾT CV (đã được format lại) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">description</span>
                            <h3 class="font-semibold text-gray-800">Chi tiết CV</h3>
                        </div>
                    </div>

                    @php
                        $parsedData = is_string($applicant->cv->parsed_data) ? json_decode($applicant->cv->parsed_data, true) : ($applicant->cv->parsed_data ?? []);
                    @endphp

                    @if(!$applicant->cv->parsed_data)
                        <div class="p-6">
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-r-xl p-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                                    <div>
                                        <h3 class="font-semibold text-yellow-800">CV đang được xử lý</h3>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            Hệ thống AI đang phân tích CV của ứng viên. Vui lòng quay lại sau.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-6 space-y-6">
                            <!-- Thông tin cá nhân -->
                            <div>
                                <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                    <i class="fas fa-user-circle text-blue-500"></i> Thông tin cá nhân
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-xl p-4">
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase font-semibold">Họ và tên</label>
                                        <p class="text-gray-900 font-medium">
                                            {{ $parsedData['personal_info']['name'] ?? 'Chưa có' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase font-semibold">Email</label>
                                        <p class="text-gray-900">{{ $parsedData['personal_info']['email'] ?? 'Chưa có' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase font-semibold">Số điện thoại</label>
                                        <p class="text-gray-900">{{ $parsedData['personal_info']['phone'] ?? 'Chưa có' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase font-semibold">Địa chỉ</label>
                                        <p class="text-gray-900">{{ $parsedData['personal_info']['address'] ?? 'Chưa có' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Giới thiệu -->
                            @if(!empty($parsedData['summary']))
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                        <i class="fas fa-quote-left text-blue-500"></i> Giới thiệu bản thân
                                    </h4>
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <p class="text-gray-700 italic">{{ $parsedData['summary'] }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Kỹ năng -->
                            @if(!empty($parsedData['skills']))
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                        <i class="fas fa-code text-blue-500"></i> Kỹ năng chuyên môn
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($parsedData['skills'] as $skill)
                                            <span
                                                class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium border border-indigo-100">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Kinh nghiệm làm việc -->
                            @if(!empty($parsedData['work_experience']))
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                        <i class="fas fa-briefcase text-blue-500"></i> Kinh nghiệm làm việc
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($parsedData['work_experience'] as $job)
                                            <div class="relative pl-4 border-l-2 border-blue-200 pb-4 last:pb-0">
                                                <div class="absolute w-2 h-2 bg-blue-500 rounded-full -left-[5px] top-1.5"></div>
                                                <h5 class="font-semibold text-gray-800">
                                                    {{ $job['job_title'] ?? 'Vị trí không xác định' }}</h5>
                                                <p class="text-sm font-medium text-blue-600">
                                                    {{ $job['company'] ?? 'Công ty không xác định' }}</p>
                                                <p class="text-xs text-gray-500">
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

                            <!-- Học vấn -->
                            @if(!empty($parsedData['education']))
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                        <i class="fas fa-graduation-cap text-blue-500"></i> Học vấn
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach($parsedData['education'] as $edu)
                                            <div class="flex items-start gap-3">
                                                <i class="fas fa-university text-blue-400 mt-1"></i>
                                                <div>
                                                    <h5 class="font-semibold text-gray-800">{{ $edu['degree'] ?? 'Bằng cấp' }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $edu['institution'] ?? 'Trường' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $edu['start_year'] ?? '?' }} -
                                                        {{ $edu['end_year'] ?? '?' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Dự án -->
                            @if(!empty($parsedData['projects']))
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                        <i class="fas fa-laptop-code text-blue-500"></i> Dự án đã thực hiện
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($parsedData['projects'] as $index => $project)
                                            <div class="border-b border-gray-100 last:border-0 pb-3 last:pb-0">
                                                <div class="flex items-start gap-3">
                                                    <div
                                                        class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">
                                                        {{ $index + 1 }}
                                                    </div>
                                                    <div>
                                                        <h5 class="font-semibold text-gray-800">{{ $project['name'] }}</h5>
                                                        <p class="text-gray-600 text-sm mt-1">{{ $project['description'] }}</p>
                                                        @if(!empty($project['technologies']))
                                                            <div class="flex flex-wrap gap-1.5 mt-2">
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

                            <!-- Thành tích & Chứng chỉ -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if(!empty($parsedData['achievements']))
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                            <i class="fas fa-trophy text-yellow-500"></i> Thành tích
                                        </h4>
                                        <ul class="space-y-1">
                                            @foreach($parsedData['achievements'] as $achievement)
                                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                                    <i class="fas fa-check-circle text-green-500 text-xs mt-0.5"></i>
                                                    <span>{{ $achievement }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(!empty($parsedData['certifications']))
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                            <i class="fas fa-certificate text-purple-500"></i> Chứng chỉ
                                        </h4>
                                        <ul class="space-y-1">
                                            @foreach($parsedData['certifications'] as $cert)
                                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                                    <i class="fas fa-award text-purple-500 text-xs mt-0.5"></i>
                                                    <span>{{ $cert }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <!-- Ngôn ngữ -->
                            @if(!empty($parsedData['languages']))
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                        <i class="fas fa-language text-green-500"></i> Ngôn ngữ
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($parsedData['languages'] as $lang)
                                            <span
                                                class="px-3 py-1.5 bg-green-50 text-green-700 rounded-full text-sm font-medium border border-green-100">
                                                {{ $lang }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Action Buttons for Status Update -->
                @if($applicant->status == 'pending')
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-gray-600">gavel</span>
                                <h3 class="font-semibold text-gray-800">Xét duyệt hồ sơ</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-4">
                                <form action="{{ route('recruiter.applicants.update_status', $applicant->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit"
                                        onclick="return confirm('Xác nhận duyệt hồ sơ này? Ứng viên sẽ nhận được email thông báo.')"
                                        class="flex items-center gap-2 px-6 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors font-medium shadow-sm">
                                        <span class="material-symbols-outlined text-base">check_circle</span>
                                        Duyệt hồ sơ & Gửi mail
                                    </button>
                                </form>

                                <form action="{{ route('recruiter.applicants.update_status', $applicant->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit"
                                        onclick="return confirm('Xác nhận từ chối hồ sơ này? Ứng viên sẽ nhận được email thông báo.')"
                                        class="flex items-center gap-2 px-6 py-2.5 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors font-medium shadow-sm">
                                        <span class="material-symbols-outlined text-base">close</span>
                                        Từ chối
                                    </button>
                                </form>
                            </div>
                            <p class="text-xs text-gray-400 mt-4">
                                <span class="material-symbols-outlined text-xs align-middle">info</span>
                                Khi duyệt hoặc từ chối, hệ thống sẽ tự động gửi email thông báo cho ứng viên.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="material-symbols-outlined {{ $applicant->status == 'accepted' ? 'text-green-600' : 'text-red-600' }}">info</span>
                                    <h3 class="font-semibold text-gray-800">Trạng thái hồ sơ</h3>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-semibold {{ $applicant->status == 'accepted' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $applicant->status == 'accepted' ? 'Đã duyệt' : 'Đã từ chối' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection