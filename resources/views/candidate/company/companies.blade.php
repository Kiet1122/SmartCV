@extends('layouts.master')

@section('title', 'Danh sách công ty | SmartCV - Nền tảng tuyển dụng thông minh')

@section('content')
    <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full filter blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 py-16 md:py-20 text-center">
                <div class="max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                        <i class="fas fa-building text-white text-sm"></i>
                        <span class="text-sm font-medium text-white">Đối tác của chúng tôi</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6">
                        Nhà tuyển dụng <span class="border-b-4 border-white/50">hàng đầu</span>
                    </h1>
                    <p class="text-lg text-blue-100 max-w-2xl mx-auto leading-relaxed">
                        Cùng hợp tác với những công ty hàng đầu trong nhiều lĩnh vực,
                        nơi có những cơ hội việc làm chất lượng cao đang chờ đón bạn.
                    </p>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="text-3xl font-bold text-blue-600">{{ $companies->count() }}</div>
                        <div class="text-sm text-gray-500 mt-1">Đối tác doanh nghiệp</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-blue-600">{{ $companies->sum('job_posts_count') }}</div>
                        <div class="text-sm text-gray-500 mt-1">Việc làm đang tuyển</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-blue-600">95%</div>
                        <div class="text-sm text-gray-500 mt-1">Hài lòng từ đối tác</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search & Filter Section -->
        <section class="py-8 bg-gray-50 sticky top-0 z-10 shadow-sm">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchCompany" placeholder="Tìm kiếm công ty theo tên hoặc lĩnh vực..."
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none">
                    </div>
                    <div class="flex gap-3">
                        <select id="industryFilter"
                            class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none bg-white">
                            <option value="all">📊 Tất cả lĩnh vực</option>
                            <option value="Công nghệ thông tin">💻 Công nghệ thông tin</option>
                            <option value="Tài chính - Ngân hàng">🏦 Tài chính - Ngân hàng</option>
                            <option value="Sản xuất">🏭 Sản xuất</option>
                            <option value="Bán lẻ">🛍️ Bán lẻ</option>
                            <option value="Giáo dục">📚 Giáo dục</option>
                            <option value="Y tế">🏥 Y tế</option>
                        </select>
                        <button id="resetFilter"
                            class="px-5 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                            <i class="fas fa-redo-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Companies Grid -->
        <section class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="companiesGrid">
                    @forelse($companies as $company)
                        <div class="company-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group overflow-hidden"
                            data-name="{{ strtolower($company->company_name) }}"
                            data-industry="{{ strtolower($company->industry ?? '') }}">

                            <!-- Card Header with Logo -->
                            <div class="relative h-28 bg-gradient-to-r from-blue-500 to-indigo-600">
                                <div class="absolute -bottom-8 left-6">
                                    <div
                                        class="w-20 h-20 rounded-xl bg-white shadow-lg flex items-center justify-center overflow-hidden border-4 border-white">
                                        @if($company->logo_url)
                                            <img src="{{ asset('storage/' . $company->logo_url) }}"
                                                alt="{{ $company->company_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-building text-2xl text-blue-500"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Verified Badge -->
                                @if($company->is_verified ?? false)
                                    <div
                                        class="absolute top-3 right-3 bg-emerald-500 text-white rounded-full px-2 py-1 text-xs flex items-center gap-1">
                                        <i class="fas fa-check-circle text-xs"></i>
                                        <span>Đã xác thực</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="pt-12 p-5">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition">
                                    {{ $company->company_name }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                    <span>{{ $company->address ?? 'Toàn quốc' }}</span>
                                </div>
                                <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                                    {{ $company->description ?? 'Chưa có mô tả. Đội ngũ chuyên nghiệp đang chờ đón bạn.' }}
                                </p>

                                <!-- Stats -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center">
                                            <i class="fas fa-briefcase text-blue-500 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $company->job_posts_count }}</div>
                                            <div class="text-xs text-gray-400">Việc làm</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center">
                                            <i class="fas fa-users text-green-500 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $company->company_size }}</div>
                                            <div class="text-xs text-gray-400">Nhân sự</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('public.companies.show', $company->id) }}"
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                                        Xem chi tiết
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-building text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có công ty nào</h3>
                            <p class="text-gray-500">Hiện tại chưa có công ty nào đăng ký tuyển dụng</p>
                        </div>
                    @endforelse
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

        .company-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .company-card:hover {
            transform: translateY(-4px);
        }
    </style>

    <script>
        // Search and Filter functionality
        const searchInput = document.getElementById('searchCompany');
        const industryFilter = document.getElementById('industryFilter');
        const resetBtn = document.getElementById('resetFilter');
        const cards = document.querySelectorAll('.company-card');

        function filterCompanies() {
            const searchTerm = searchInput?.value.toLowerCase() || '';
            const industry = industryFilter?.value.toLowerCase() || 'all';

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const cardIndustry = card.dataset.industry || '';

                let show = true;

                if (searchTerm && !name.includes(searchTerm)) {
                    show = false;
                }

                if (industry !== 'all' && cardIndustry !== industry) {
                    show = false;
                }

                card.style.display = show ? 'block' : 'none';
            });

            // Update grid layout when cards are hidden
            const visibleCount = Array.from(cards).filter(card => card.style.display !== 'none').length;
            const grid = document.getElementById('companiesGrid');
            if (visibleCount === 0) {
                if (!document.querySelector('.no-results')) {
                    const noResults = document.createElement('div');
                    noResults.className = 'col-span-3 text-center py-12 no-results';
                    noResults.innerHTML = `
                                <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-search text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Không tìm thấy công ty</h3>
                                <p class="text-gray-500">Vui lòng thử lại với từ khóa khác</p>
                            `;
                    grid?.appendChild(noResults);
                }
            } else {
                const noResults = document.querySelector('.no-results');
                if (noResults) noResults.remove();
            }
        }

        searchInput?.addEventListener('keyup', filterCompanies);
        industryFilter?.addEventListener('change', filterCompanies);

        resetBtn?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (industryFilter) industryFilter.value = 'all';
            filterCompanies();
        });
    </script>
@endsection