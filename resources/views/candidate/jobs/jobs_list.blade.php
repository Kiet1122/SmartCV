@extends('layouts.master')

@section('title', 'Danh sách việc làm | SmartCV - Tìm việc thông minh với AI')

@section('content')
    <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-16 md:py-20 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Việc làm chất lượng cao</h1>
                <p class="text-lg text-blue-100 max-w-2xl mx-auto">Khám phá những cơ hội việc làm hấp dẫn từ các công ty
                    hàng đầu</p>
            </div>
        </section>

        <!-- Search & Filter Section -->
        <section class="py-8 bg-white border-b border-gray-100 sticky top-0 z-10 shadow-sm">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <form method="GET" action="{{ route('candidate.jobs.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Tìm kiếm việc làm..."
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>

                        <!-- Salary Filter -->
                        <select name="salary"
                            class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">💰 Tất cả mức lương</option>
                            <option value="under_10" {{ request('salary') == 'under_10' ? 'selected' : '' }}>&lt; 10 triệu
                            </option>
                            <option value="10_20" {{ request('salary') == '10_20' ? 'selected' : '' }}>10 - 20 triệu</option>
                            <option value="20_30" {{ request('salary') == '20_30' ? 'selected' : '' }}>20 - 30 triệu</option>
                            <option value="above_30" {{ request('salary') == 'above_30' ? 'selected' : '' }}>&gt; 30 triệu
                            </option>
                        </select>

                        <!-- Experience Filter -->
                        <select name="experience"
                            class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">📅 Tất cả kinh nghiệm</option>
                            <option value="fresh" {{ request('experience') == 'fresh' ? 'selected' : '' }}>Chưa có kinh nghiệm
                            </option>
                            <option value="1_3" {{ request('experience') == '1_3' ? 'selected' : '' }}>1 - 3 năm</option>
                            <option value="3_5" {{ request('experience') == '3_5' ? 'selected' : '' }}>3 - 5 năm</option>
                            <option value="5_plus" {{ request('experience') == '5_plus' ? 'selected' : '' }}>5+ năm</option>
                        </select>

                        <!-- Skill Filter -->
                        <select name="skill"
                            class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">🎯 Tất cả kỹ năng</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ request('skill') == $skill->id ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                            <i class="fas fa-search mr-2"></i>Tìm kiếm
                        </button>
                        @if(request()->anyFilled(['search', 'salary', 'experience', 'skill']))
                            <a href="{{ route('public.jobs.index') }}"
                                class="ml-3 px-6 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                                <i class="fas fa-redo-alt mr-2"></i>Đặt lại
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <!-- Results Section -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="mb-6 flex justify-between items-center">
                    <p class="text-gray-500">Tìm thấy <span class="font-semibold text-blue-600">{{ $jobs->total() }}</span>
                        việc làm</p>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sắp xếp:</span>
                        <select id="sortOrder" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5">
                            <option value="latest">Mới nhất</option>
                            <option value="oldest">Cũ nhất</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4" id="jobsList">
                    @forelse($jobs as $job)
                        <div
                            class="job-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
                            <div class="flex flex-wrap md:flex-nowrap gap-6">
                                <!-- Logo -->
                                <div
                                    class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center overflow-hidden shrink-0">
                                    @if($job->company && $job->company->logo_url)
                                        <img src="{{ asset('storage/' . $job->company->logo_url) }}"
                                            alt="{{ $job->company->company_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-building text-2xl text-blue-500"></i>
                                    @endif
                                </div>

                                <!-- Job Info -->
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-start justify-between gap-2">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                                                <a href="{{ route('candidate.jobs.show', $job->id) }}">{{ $job->title }}</a>
                                            </h3>
                                            <p class="text-gray-500 text-sm mt-1">
                                                <i
                                                    class="fas fa-building mr-1"></i>{{ $job->company->company_name ?? 'Công ty' }}
                                                <span class="mx-2">•</span>
                                                <i
                                                    class="fas fa-map-marker-alt mr-1"></i>{{ $job->company->address ?? 'Toàn quốc' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-blue-600">
                                                {{ $job->salary_range ?? 'Thỏa thuận' }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">Kinh nghiệm:
                                                {{ $job->experience_required ?? 0 }}+ năm
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-gray-500 text-sm mt-3 line-clamp-2">
                                        {{ Str::limit($job->description ?? '', 120) }}
                                    </p>

                                    <div class="flex flex-wrap gap-2 mt-4">
                                        @foreach($job->skills->take(4) as $skill)
                                            <span
                                                class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $skill->name }}</span>
                                        @endforeach
                                        @if($job->skills->count() > 4)
                                            <span
                                                class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">+{{ $job->skills->count() - 4 }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action -->
                                <div class="shrink-0 text-center">
                                    <a href="{{ route('candidate.jobs.show', $job->id) }}"
                                        class="inline-block px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                        Ứng tuyển
                                    </a>
                                    <p class="text-xs text-gray-400 mt-2">Hạn nộp:
                                        {{ $job->created_at->addDays(30)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-briefcase text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Không tìm thấy việc làm</h3>
                            <p class="text-gray-500">Vui lòng thử lại với từ khóa khác hoặc xóa bộ lọc</p>
                            <a href="{{ route('public.jobs.index') }}"
                                class="inline-block mt-4 text-blue-600 hover:underline">Xem tất cả việc làm</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $jobs->withQueryString()->links() }}
                </div>
            </div>
        </section>
    </main>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        // Sort functionality
        document.getElementById('sortOrder')?.addEventListener('change', function () {
            const container = document.getElementById('jobsList');
            const cards = Array.from(container.querySelectorAll('.job-card'));
            const isLatest = this.value === 'latest';

            cards.sort((a, b) => {
                // Lấy ID hoặc ngày từ data attribute
                const idA = parseInt(a.dataset.id || 0);
                const idB = parseInt(b.dataset.id || 0);
                return isLatest ? idB - idA : idA - idB;
            });

            cards.forEach(card => container.appendChild(card));
        });
    </script>
@endsection