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
                <div
                    class="bg-surface-container p-5 md:p-6 rounded-xl border border-outline-variant/15 flex flex-col gap-5">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-magic text-primary text-xl"></i>
                        <h2 class="font-headline text-lg md:text-xl font-bold">Gợi ý việc làm từ AI</h2>
                    </div>

                    <div class="space-y-3">
                        <div
                            class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/5 hover:scale-[1.02] transition-transform cursor-pointer relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-2">
                                <span
                                    class="bg-primary/10 text-primary px-2 py-0.5 rounded text-[10px] font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle text-[10px]"></i> 95% phù hợp
                                </span>
                            </div>
                            <div class="flex gap-3 items-center">
                                <div
                                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center font-bold text-primary text-sm">
                                    S</div>
                                <div>
                                    <h4 class="text-sm font-bold leading-tight">Senior Product Designer</h4>
                                    <p class="text-xs text-on-surface-variant">TechCorp • Remote</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/5 hover:scale-[1.02] transition-transform cursor-pointer relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-2">
                                <span
                                    class="bg-primary/10 text-primary px-2 py-0.5 rounded text-[10px] font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle text-[10px]"></i> 92% phù hợp
                                </span>
                            </div>
                            <div class="flex gap-3 items-center">
                                <div
                                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center font-bold text-primary text-sm">
                                    F</div>
                                <div>
                                    <h4 class="text-sm font-bold leading-tight">Frontend Developer</h4>
                                    <p class="text-xs text-on-surface-variant">Figma • Hồ Chí Minh</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/5 hover:scale-[1.02] transition-transform cursor-pointer relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-2">
                                <span
                                    class="bg-primary/10 text-primary px-2 py-0.5 rounded text-[10px] font-bold flex items-center gap-1">
                                    <i class="fas fa-check-circle text-[10px]"></i> 88% phù hợp
                                </span>
                            </div>
                            <div class="flex gap-3 items-center">
                                <div
                                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center font-bold text-primary text-sm">
                                    A</div>
                                <div>
                                    <h4 class="text-sm font-bold leading-tight">AI Engineer</h4>
                                    <p class="text-xs text-on-surface-variant">AI Startup • Hà Nội</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="#"
                        class="w-full py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all active:scale-[0.98] text-center">
                        Xem thêm gợi ý
                    </a>
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