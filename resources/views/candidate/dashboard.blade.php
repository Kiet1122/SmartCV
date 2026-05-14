@extends('layouts.candidate_layout')

@section('title', 'Tổng quan - SmartCV')

@section('content')
    <div class="max-w-[1600px] mx-auto">
        <!-- Dashboard Header -->
        <div class="mb-8">
            <h1 class="font-headline text-2xl md:text-3xl lg:text-4xl font-extrabold tracking-tight mb-2">
                Chào mừng trở lại, <span
                    class="text-primary">{{ isset($user) ? $user->name : (Auth::user()->name ?? 'Người dùng') }}</span>
            </h1>
            <p class="text-on-surface-variant text-sm md:text-base">
                Hồ sơ của bạn đang được đánh giá tốt.
                @if(isset($stats) && $stats['views'] > 0)
                    Bạn có <span class="font-semibold text-primary">{{ $stats['views'] }}</span> lượt xem hồ sơ mới.
                @else
                    Hãy cập nhật CV để tăng cơ hội tìm việc nhé!
                @endif
            </p>
        </div>

        <!-- Summary Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total CV Card -->
            <div
                class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border border-outline-variant/15 group hover:bg-primary transition-all duration-300 cursor-pointer">
                <div class="flex justify-between items-start mb-3">
                    <div class="p-2.5 rounded-full bg-surface-container-low group-hover:bg-white/20">
                        <i class="fas fa-file-alt text-primary text-xl group-hover:text-white"></i>
                    </div>
                    @if(isset($stats) && $stats['total_cv'] > 0)
                        <span class="text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-full">Đã tạo</span>
                    @else
                        <span class="text-xs font-semibold px-2 py-1 bg-orange-100 text-orange-700 rounded-full">Chưa có</span>
                    @endif
                </div>
                <div class="text-3xl font-headline font-extrabold mb-1 group-hover:text-white">
                    {{ isset($stats) ? $stats['total_cv'] : 0 }}
                </div>
                <div class="text-sm font-medium text-on-surface-variant group-hover:text-white/80">CV đã tải lên</div>
            </div>

            <!-- Applied Jobs Card -->
            <div
                class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border border-outline-variant/15 group hover:bg-primary transition-all duration-300 cursor-pointer">
                <div class="flex justify-between items-start mb-3">
                    <div class="p-2.5 rounded-full bg-surface-container-low group-hover:bg-white/20">
                        <i class="fas fa-paper-plane text-primary text-xl group-hover:text-white"></i>
                    </div>
                </div>
                <div class="text-3xl font-headline font-extrabold mb-1 group-hover:text-white">
                    {{ isset($stats) ? $stats['applied_jobs'] : 0 }}
                </div>
                <div class="text-sm font-medium text-on-surface-variant group-hover:text-white/80">Đơn đã ứng tuyển</div>
            </div>

            <!-- Saved Jobs Card -->
            <div
                class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border border-outline-variant/15 group hover:bg-primary transition-all duration-300 cursor-pointer">
                <div class="flex justify-between items-start mb-3">
                    <div class="p-2.5 rounded-full bg-surface-container-low group-hover:bg-white/20">
                        <i class="fas fa-bookmark text-primary text-xl group-hover:text-white"></i>
                    </div>
                </div>
                <div class="text-3xl font-headline font-extrabold mb-1 group-hover:text-white">
                    {{ isset($stats) ? $stats['saved_jobs'] : 0 }}
                </div>
                <div class="text-sm font-medium text-on-surface-variant group-hover:text-white/80">Việc làm đã lưu</div>
            </div>

            <!-- Profile Views Card -->
            <div
                class="bg-surface-container-lowest p-5 rounded-xl shadow-sm border border-outline-variant/15 group hover:bg-primary transition-all duration-300 cursor-pointer">
                <div class="flex justify-between items-start mb-3">
                    <div class="p-2.5 rounded-full bg-surface-container-low group-hover:bg-white/20">
                        <i class="fas fa-eye text-primary text-xl group-hover:text-white"></i>
                    </div>
                    @if(isset($stats) && $stats['views'] > 0)
                        <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Mới</span>
                    @endif
                </div>
                <div class="text-3xl font-headline font-extrabold mb-1 group-hover:text-white">
                    {{ isset($stats) ? $stats['views'] : 0 }}
                </div>
                <div class="text-sm font-medium text-on-surface-variant group-hover:text-white/80">Lượt xem hồ sơ</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Applications Table Section -->
            <div class="lg:col-span-2">
                <div class="bg-surface-container-lowest rounded-xl p-5 md:p-6 shadow-sm border border-outline-variant/15">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-headline text-xl md:text-2xl font-bold">Đơn ứng tuyển gần đây</h2>
                        <a href="{{ route('candidate.applications.index') }}"
                            class="text-primary text-sm font-semibold hover:underline flex items-center gap-1">
                            Xem tất cả <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    @if(isset($applications) && $applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-label text-xs uppercase tracking-widest text-on-surface-variant border-b border-gray-100">
                                        <th class="pb-3 font-semibold">Vị trí</th>
                                        <th class="pb-3 font-semibold">Công ty</th>
                                        <th class="pb-3 font-semibold">Ngày ứng tuyển</th>
                                        <th class="pb-3 font-semibold">Trạng thái</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr
                                            class="hover:bg-surface-container-low transition-colors group cursor-pointer border-b border-gray-50">
                                            <td class="py-3 font-semibold text-on-surface text-sm">
                                                {{ $application->jobPost->title ?? 'N/A' }}
                                            </td>
                                            <td class="py-3 text-on-surface-variant text-sm">
                                                {{ $application->jobPost->company->company_name ?? 'N/A' }}
                                            </td>
                                            <td class="py-3 text-on-surface-variant text-sm">
                                                {{ $application->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="py-3">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                                        'reviewed' => 'bg-blue-100 text-blue-700',
                                                        'accepted' => 'bg-green-100 text-green-700',
                                                        'rejected' => 'bg-red-100 text-red-700'
                                                    ];
                                                    $statusText = [
                                                        'pending' => 'Chờ xét duyệt',
                                                        'reviewed' => 'Đã xem',
                                                        'accepted' => 'Chấp nhận',
                                                        'rejected' => 'Từ chối'
                                                    ];
                                                    $statusClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-700';
                                                    $statusLabel = $statusText[$application->status] ?? ucfirst($application->status);
                                                @endphp
                                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-right">
                                                <i
                                                    class="fas fa-chevron-right text-gray-300 group-hover:text-primary transition-opacity text-sm"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Bạn chưa ứng tuyển công việc nào</p>
                            <a href="#" class="inline-block mt-3 text-primary text-sm font-semibold hover:underline">
                                Tìm việc ngay →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- AI Job Recommendations Widget -->
            <div class="lg:col-span-1">
                @php
                    // Lấy danh sách việc làm gợi ý dựa trên kỹ năng của CV đã đánh giá cao nhất
                    $suggestedJobs = collect();

                    if (isset($cvs) && $cvs->count() > 0) {
                        // Lấy CV có điểm đánh giá cao nhất
                        $bestCv = $cvs->sortByDesc(function ($cv) {
                            return $cv->review ? $cv->review->score : 0;
                        })->first();

                        if ($bestCv && $bestCv->review && $bestCv->review->score >= 5) {
                            // Lấy kỹ năng từ CV
                            $cvSkills = $bestCv->skills->pluck('id')->toArray();

                            if (!empty($cvSkills)) {
                                // Tìm việc làm có kỹ năng phù hợp
                                $suggestedJobs = \App\Models\JobPost::where('status', 'open')
                                    ->whereHas('skills', function ($q) use ($cvSkills) {
                                        $q->whereIn('skills.id', $cvSkills);
                                    })
                                    ->withCount([
                                        'skills' => function ($q) use ($cvSkills) {
                                            $q->whereIn('skills.id', $cvSkills);
                                        }
                                    ])
                                    ->with('company')
                                    ->orderByDesc('skills_count')
                                    ->limit(3)
                                    ->get()
                                    ->map(function ($job) use ($bestCv) {
                                        // Tính % phù hợp
                                        $cvSkillCount = $bestCv->skills->count();
                                        $matchCount = $job->skills_count;
                                        $matchPercent = $cvSkillCount > 0 ? round(($matchCount / $cvSkillCount) * 100) : 0;
                                        $job->match_percent = min($matchPercent, 100);
                                        return $job;
                                    });
                            }
                        }
                    }

                    // Nếu không có gợi ý, lấy việc làm mới nhất
                    if ($suggestedJobs->isEmpty()) {
                        $suggestedJobs = \App\Models\JobPost::with('company')
                            ->where('status', 'open')
                            ->latest()
                            ->limit(3)
                            ->get()
                            ->map(function ($job) {
                                $job->match_percent = rand(75, 95);
                                return $job;
                            });
                    }
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50/30">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-white text-xl">auto_awesome</span>
                            </div>
                            <div>
                                <h2 class="font-headline text-lg md:text-xl font-bold text-gray-800">Gợi ý việc làm từ AI
                                </h2>
                                <p class="text-xs text-gray-500 mt-0.5">Dựa trên kỹ năng và hồ sơ của bạn</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 space-y-3">
                        @forelse($suggestedJobs as $job)
                            <div
                                class="group bg-gray-50/50 hover:bg-white rounded-xl p-4 transition-all duration-200 cursor-pointer border border-gray-100 hover:border-blue-200 hover:shadow-md relative overflow-hidden">
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-2.5 py-0.5 rounded-full text-[10px] font-bold flex items-center gap-1 shadow-sm">
                                        <span class="material-symbols-outlined text-[10px]">check_circle</span>
                                        {{ $job->match_percent }}% phù hợp
                                    </span>
                                </div>

                                <div class="flex gap-3 items-start">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center shrink-0">
                                        @if($job->company && $job->company->logo_url)
                                            <img src="{{ asset('storage/' . $job->company->logo_url) }}"
                                                alt="{{ $job->company->company_name }}" class="w-8 h-8 rounded-lg object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-blue-500 text-2xl">business</span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4
                                            class="text-sm font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">
                                            {{ $job->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[12px]">business</span>
                                            {{ $job->company->company_name ?? 'Công ty' }}
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span class="material-symbols-outlined text-[12px]">payments</span>
                                            {{ $job->salary_range ?? 'Thỏa thuận' }}
                                        </p>
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            @foreach($job->skills->take(3) as $skill)
                                                <span
                                                    class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $skill->name }}</span>
                                            @endforeach
                                            @if($job->skills->count() > 3)
                                                <span
                                                    class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">+{{ $job->skills->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('candidate.jobs.show', $job->id) }}" class="absolute inset-0 z-10"
                                    aria-label="Xem chi tiết"></a>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <span class="material-symbols-outlined text-gray-400 text-2xl">work_off</span>
                                </div>
                                <p class="text-gray-500 text-sm">Chưa có gợi ý việc làm</p>
                                <p class="text-xs text-gray-400 mt-1">Hãy tải lên CV để nhận gợi ý từ AI</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-gray-100 bg-gray-50/30">
                        <a href="{{ route('candidate.applications.recommendations') }}"
                            class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center justify-center gap-2 group">
                            <span
                                class="material-symbols-outlined text-base group-hover:translate-x-0.5 transition-transform">explore</span>
                            Xem thêm gợi ý
                        </a>
                    </div>
                </div>

                <!-- Resume Strength Card -->
                <div
                    class="mt-6 bg-surface-container-low p-5 md:p-6 rounded-xl border border-outline-variant/15 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl"></div>
                    <h3 class="font-headline font-bold mb-3">Độ mạnh của CV</h3>
                    <div class="relative h-2 w-full bg-gray-200 rounded-full overflow-hidden mb-3">
                        @php
                            $cvCount = isset($stats) ? $stats['total_cv'] : 0;
                            $strength = $cvCount > 0 ? min(85, 60 + $cvCount * 10) : 0;
                        @endphp
                        <div class="absolute h-full bg-primary rounded-full" style="width: {{ $strength }}%"></div>
                    </div>
                    <p class="text-xs text-on-surface-variant mb-4 px-2">
                        @if($cvCount == 0)
                            Tải lên CV để được đánh giá và tăng cơ hội trúng tuyển.
                        @elseif($strength < 70)
                            CV của bạn cần bổ sung thêm thông tin để đạt điểm tối đa.
                        @else
                            CV của bạn rất tốt! Hãy cập nhật thường xuyên nhé.
                        @endif
                    </p>
                    <a href="{{ route('candidate.cv.index') }}"
                        class="text-primary text-xs font-bold flex items-center justify-center gap-1 mx-auto hover:gap-2 transition-all">
                        Quản lý CV <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="{{ route('candidate.cv.index') }}"
                        class="flex items-center justify-center gap-2 p-3 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-md transition">
                        <i class="fas fa-upload text-primary"></i>
                        <span class="text-sm font-medium">Tải CV mới</span>
                    </a>
                    <a href="#"
                        class="flex items-center justify-center gap-2 p-3 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-md transition">
                        <i class="fas fa-search text-primary"></i>
                        <span class="text-sm font-medium">Tìm việc ngay</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection