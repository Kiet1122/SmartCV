@extends('layouts.master')

@section('title', $job->title . ' | SmartCV - Tìm việc thông minh với AI')
@section('content')
    <main>
        <!-- Breadcrumb -->
        <section class="py-4 bg-gray-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route('public.home') }}" class="hover:text-blue-600">Trang chủ</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="{{ route('candidate.jobs.index') }}" class="hover:text-blue-600">Việc làm</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-700">{{ $job->title }}</span>
                </div>
            </div>
        </section>

        <!-- Job Detail Section -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                            <!-- Job Header -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex flex-wrap items-start justify-between gap-4">
                                    <div>
                                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $job->title }}</h1>
                                        <div class="flex flex-wrap gap-3 text-gray-500 text-sm">
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-building"></i> {{ $company->company_name ?? 'Công ty' }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-map-marker-alt"></i> {{ $company->address ?? 'Toàn quốc' }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-clock"></i> Đăng {{ $job->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-blue-600">
                                            {{ $job->salary_range ?? 'Thỏa thuận' }}</div>
                                        <div class="text-xs text-gray-400 mt-1">Kinh nghiệm:
                                            {{ $job->experience_required ?? 0 }}+ năm</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Description -->
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-file-alt text-blue-500"></i> Mô tả công việc
                                </h3>
                                <div class="prose max-w-none text-gray-600 leading-relaxed">
                                    {!! nl2br(e($job->description ?? 'Chưa có mô tả chi tiết')) !!}
                                </div>
                            </div>

                            <!-- Requirements -->
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-check-circle text-blue-500"></i> Yêu cầu công việc
                                </h3>
                                <div class="space-y-3">
                                    @if($job->education_required)
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-graduation-cap text-blue-500 mt-1"></i>
                                            <div>
                                                <span class="font-medium text-gray-700">Trình độ:</span>
                                                <span class="text-gray-600">{{ $job->education_required }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($job->experience_required)
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-briefcase text-blue-500 mt-1"></i>
                                            <div>
                                                <span class="font-medium text-gray-700">Kinh nghiệm:</span>
                                                <span class="text-gray-600">{{ $job->experience_required }}+ năm</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($skills->count() > 0)
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-code text-blue-500 mt-1"></i>
                                            <div>
                                                <span class="font-medium text-gray-700">Kỹ năng yêu cầu:</span>
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    @foreach($skills as $skill)
                                                        <span
                                                            class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $skill->name }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Benefits -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-gift text-blue-500"></i> Quyền lợi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <span>Lương thưởng hấp dẫn theo năng lực</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <span>Bảo hiểm đầy đủ theo quy định</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <span>Môi trường làm việc chuyên nghiệp</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <span>Cơ hội thăng tiến rõ ràng</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <span>Đào tạo kỹ năng chuyên sâu</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 text-sm"></i>
                                        <span>Du lịch, teambuilding hàng năm</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Related Jobs Section -->
                        @if($relatedJobs->count() > 0)
                            <div class="mt-8 bg-white rounded-2xl shadow-sm overflow-hidden">
                                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                        <i class="fas fa-link text-blue-500"></i> Việc làm liên quan
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">Dựa trên kỹ năng và ngành nghề của bạn</p>
                                </div>
                                <div class="p-4 divide-y divide-gray-100">
                                    @foreach($relatedJobs as $related)
                                        <div class="py-4 first:pt-0 last:pb-0 hover:bg-gray-50 transition px-2 rounded-lg">
                                            <a href="{{ route('candidate.jobs.show', $related->id) }}" class="block">
                                                <div class="flex flex-wrap items-center justify-between gap-3">
                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-gray-800 hover:text-blue-600 transition">
                                                            {{ $related->title }}
                                                        </h4>
                                                        <div class="flex flex-wrap gap-3 text-sm text-gray-500 mt-1">
                                                            <span class="flex items-center gap-1">
                                                                <i class="fas fa-building"></i>
                                                                {{ $related->company->company_name ?? 'Công ty' }}
                                                            </span>
                                                            <span class="flex items-center gap-1">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                {{ $related->company->address ?? 'Toàn quốc' }}
                                                            </span>
                                                        </div>
                                                        <div class="flex flex-wrap gap-2 mt-2">
                                                            @foreach($related->skills->take(3) as $skill)
                                                                <span
                                                                    class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $skill->name }}</span>
                                                            @endforeach
                                                            @if($related->skills->count() > 3)
                                                                <span
                                                                    class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">+{{ $related->skills->count() - 3 }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-md font-semibold text-blue-600">
                                                            {{ $related->salary_range ?? 'Thỏa thuận' }}</div>
                                                        <span
                                                            class="text-xs text-gray-400">{{ $related->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="p-4 bg-gray-50 text-center border-t border-gray-100">
                                    <a href="{{ route('candidate.jobs.index') }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        Xem tất cả việc làm <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Apply Card -->
                        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 sticky top-24">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $job->salary_range ?? 'Thỏa thuận' }}
                                </div>
                                <p class="text-gray-500 text-sm mb-4">Kinh nghiệm: {{ $job->experience_required ?? 0 }}+ năm
                                </p>

                                @auth
                                    @if(auth()->user()->role === 'candidate')
                                        <form action="{{ route('candidate.jobs.apply', $job->id) }}" method="POST">
                                            @csrf <!-- Bắt buộc phải có để tránh lỗi 419 -->
                                            <button type="submit" class="btn-apply">
                                                Ứng tuyển ngay
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-md text-center">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập để ứng tuyển
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-md text-center">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập để ứng tuyển
                                    </a>
                                @endauth

                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <button id="saveJobBtn" data-job-id="{{ $job->id }}"
                                        class="w-full py-2.5 border border-gray-300 text-gray-600 rounded-xl font-medium hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                        <i class="{{ $isSaved ? 'fas fa-bookmark' : 'far fa-bookmark' }}"></i>
                                        {{ $isSaved ? 'Đã lưu tin' : 'Lưu tin' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Company Info Card -->
                        <div class="bg-white rounded-2xl shadow-sm p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center overflow-hidden">
                                    @if($company && $company->logo_url)
                                        <img src="{{ asset('storage/' . $company->logo_url) }}"
                                            alt="{{ $company->company_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-building text-2xl text-blue-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $company->company_name ?? 'Công ty' }}</h3>
                                    <a href="{{ route('candidate.companies.show', $company->id) }}"
                                        class="text-sm text-blue-600 hover:underline">Xem trang công ty</a>
                                </div>
                            </div>

                            <div class="space-y-3 text-sm text-gray-600">
                                @if($company && $company->industry)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-tag text-blue-500 w-5"></i>
                                        <span>{{ $company->industry }}</span>
                                    </div>
                                @endif

                                @if($company && $company->company_size)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-users text-blue-500 w-5"></i>
                                        <span>{{ number_format($company->company_size) }} nhân viên</span>
                                    </div>
                                @endif

                                @if($company && $company->address)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-blue-500 w-5"></i>
                                        <span>{{ $company->address }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('saveJobBtn')?.addEventListener('click', async function () {
            @auth
                    @if(auth()->user()->role === 'candidate')
                        const btn = this;
                        const originalHtml = btn.innerHTML;

                        btn.disabled = true;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

                        try {
                            const response = await fetch('{{ route("candidate.saved_jobs.toggle", $job->id) }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (data.success) {
                                if (data.saved) {
                                    btn.innerHTML = '<i class="fas fa-bookmark"></i> Đã lưu tin';
                                    btn.classList.add('text-blue-600', 'border-blue-300');
                                } else {
                                    btn.innerHTML = '<i class="far fa-bookmark"></i> Lưu tin';
                                    btn.classList.remove('text-blue-600', 'border-blue-300');
                                }
                            } else {
                                btn.innerHTML = originalHtml;
                                alert(data.message || 'Có lỗi xảy ra');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            btn.innerHTML = originalHtml;
                            alert('Có lỗi xảy ra, vui lòng thử lại');
                        } finally {
                            btn.disabled = false;
                        }
                    @else
                    window.location.href = '{{ route("login") }}';
                @endif
            @else
                window.location.href = '{{ route("login") }}';
            @endauth
        });
    </script>
@endsection