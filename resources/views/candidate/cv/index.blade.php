@extends('layouts.candidate_layout')

@section('title', 'Quản lý CV - SmartCV')

@section('content')
    <main class="max-w-7xl mx-auto">
        <!-- Hero Header -->
        <header class="mb-12">
            <h1 class="text-4xl font-extrabold font-headline tracking-[-0.03em] text-on-surface mb-2">
                Quản lý Hồ sơ CV
            </h1>
            <p class="text-on-surface-variant max-w-2xl leading-relaxed">
                Tập trung quản lý các bản CV của bạn. Tải lên nhiều phiên bản CV để AI phân tích và tối ưu hóa cho từng vị trí công việc.
            </p>
        </header>

        <!-- Upload Section -->
        <section class="mb-16">
            <form action="{{ route('candidate.cv.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="relative group cursor-pointer">
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary to-primary-container rounded-xl blur opacity-10 group-hover:opacity-20 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative flex flex-col items-center justify-center border-2 border-dashed border-outline-variant rounded-xl p-16 bg-surface-container-lowest hover:bg-surface-container-low transition-all duration-300"
                         onclick="document.getElementById('cv_file').click()">
                        <input id="cv_file" name="cv_file" type="file" class="hidden" accept=".pdf" required onchange="handleFileSelect(this)">
                        <div class="w-16 h-16 bg-primary-fixed text-on-primary-fixed rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xl font-bold font-headline mb-2">Tải lên CV (PDF)</h3>
                            <p class="text-on-surface-variant text-sm mb-6">Kéo thả hoặc nhấp vào đây để chọn file</p>
                            <div class="flex gap-4 justify-center">
                                <span class="px-3 py-1 bg-surface-container-high rounded-full text-[10px] font-bold tracking-wider text-secondary uppercase">Tối đa 5MB</span>
                                <span class="px-3 py-1 bg-surface-container-high rounded-full text-[10px] font-bold tracking-wider text-secondary uppercase">Định dạng PDF</span>
                            </div>
                            <div id="fileNameDisplay" class="text-xs text-green-600 font-semibold mt-3 hidden"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="mt-6 w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                        {{ isset($cvs) && $cvs->count() >= 5 ? 'disabled' : '' }}>
                    <i class="fas fa-microchip"></i>
                    Phân tích bằng AI
                </button>
            </form>
        </section>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 text-sm flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-sm flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @error('cv_file')
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-sm flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                <span>{{ $message }}</span>
            </div>
        @enderror

        <!-- Stats Row -->
        @php
            $cvCount = isset($cvs) ? $cvs->count() : 0;
            $parsedCount = isset($cvs) ? $cvs->filter(function ($cv) {
                return $cv->parsed_data; })->count() : 0;
            $defaultCv = isset($cvs) ? $cvs->firstWhere('is_default', true) : null;
            $parsedPercent = $cvCount > 0 ? round(($parsedCount / $cvCount) * 100) : 0;
        @endphp

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-surface-container-low p-6 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-outline-variant uppercase tracking-widest mb-1">Tổng số CV</p>
                    <p class="text-2xl font-bold font-headline">{{ $cvCount }}/5 Files</p>
                </div>
                <div class="w-12 h-12 bg-surface-container-lowest rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-file-alt text-primary text-xl"></i>
                </div>
            </div>
            <div class="bg-surface-container-low p-6 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-outline-variant uppercase tracking-widest mb-1">Đã phân tích AI</p>
                    <p class="text-2xl font-bold font-headline">{{ $parsedPercent }}%</p>
                </div>
                <div class="w-12 h-12 bg-surface-container-lowest rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-robot text-primary text-xl"></i>
                </div>
            </div>
            <div class="bg-surface-container-low p-6 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-outline-variant uppercase tracking-widest mb-1">CV mặc định</p>
                    <p class="text-2xl font-bold font-headline truncate max-w-[180px]">{{ $defaultCv ? ($defaultCv->cv_name ?? Str::limit(basename($defaultCv->file_url), 20)) : 'Chưa có' }}</p>
                </div>
                <div class="w-12 h-12 bg-surface-container-lowest rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-star text-primary text-xl"></i>
                </div>
            </div>
        </section>

        <!-- CV Grid -->
        <section>
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-2xl font-bold font-headline">Danh sách CV</h2>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i> {{ $cvCount }}/5 CV đã sử dụng
                </div>
            </div>

            @if($cvCount > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($cvs as $cv)
                        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_4px_20px_rgba(18,28,40,0.04)] relative group transition-transform hover:-translate-y-1">
                            <!-- Badge mặc định -->
                            @if($cv->is_default)
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="px-2 py-1 bg-primary text-on-primary text-[10px] font-bold rounded uppercase tracking-tighter">
                                        <i class="fas fa-star text-xs mr-1"></i> Mặc định
                                    </span>
                                </div>
                            @endif

                            <!-- Dropdown menu -->
                            <div class="absolute top-4 right-4 z-10">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $cv->id }})" class="p-2 hover:bg-surface-container-low rounded-full transition-colors">
                                        <i class="fas fa-ellipsis-v text-outline"></i>
                                    </button>
                                    <div id="dropdown-{{ $cv->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-20">
                                        <div class="py-1">
                                            @if(!$cv->is_default)
                                                <form action="{{ route('candidate.cv.set_default', $cv->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 flex items-center gap-2">
                                                        <i class="fas fa-star"></i> Đặt làm mặc định
                                                    </button>
                                                </form>
                                            @endif
                                            <button onclick="openEditModal({{ $cv->id }}, '{{ addslashes($cv->cv_name ?? basename($cv->file_url)) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2">
                                                <i class="fas fa-pen"></i> Đổi tên CV
                                            </button>
                                            <form action="{{ route('candidate.cv.destroy', $cv->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa CV này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 flex items-center gap-2">
                                                    <i class="fas fa-trash"></i> Xóa CV
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6 mt-4">
                                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-4">
                                    <i class="fas fa-file-pdf text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-lg leading-tight mb-1 truncate pr-8" title="{{ $cv->cv_name ?? basename($cv->file_url) }}">
                                    {{ $cv->cv_name ?? Str::limit(basename($cv->file_url), 30) }}
                                </h4>
                                <p class="text-xs text-on-surface-variant">
                                    <i class="far fa-calendar-alt mr-1"></i> Tải lên: {{ $cv->created_at ? $cv->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </p>
                                @if($cv->experience_years)
                                    <p class="text-xs text-purple-600 mt-1">
                                        <i class="fas fa-briefcase mr-1"></i> {{ $cv->experience_years }} năm kinh nghiệm
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-outline-variant/15">
                                <div class="flex -space-x-2">
                                    @if($cv->parsed_data)
                                        <div class="w-6 h-6 rounded-full bg-primary/10 border-2 border-surface flex items-center justify-center" title="Đã phân tích AI">
                                            <i class="fas fa-check text-[10px] text-primary"></i>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-yellow-100 border-2 border-surface flex items-center justify-center" title="Chờ xử lý">
                                            <i class="fas fa-spinner fa-pulse text-[10px] text-yellow-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ asset('storage/' . $cv->file_url) }}" target="_blank" class="text-gray-500 hover:text-blue-600 text-xs font-semibold flex items-center gap-1 bg-gray-50 px-3 py-1.5 rounded-md transition-colors">
                                        <i class="fas fa-file-pdf"></i> Xem PDF
                                    </a>
                                    
                                    <a href="{{ route('candidate.cv.show', $cv->id) }}" class="text-blue-500 hover:text-blue-700 text-xs font-semibold flex items-center gap-1 bg-blue-50 px-3 py-1.5 rounded-md transition-colors">
                                        <i class="fas fa-circle-info"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant">
                    <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Chưa có CV nào</h3>
                    <p class="text-gray-500 text-sm mb-4">Tải lên CV đầu tiên để hệ thống AI phân tích và gợi ý việc làm phù hợp</p>
                    <button onclick="document.getElementById('cv_file').click()" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition">
                        <i class="fas fa-plus"></i>
                        Tải CV ngay
                    </button>
                </div>
            @endif
        </section>
    </main>

    <!-- Edit CV Name Modal -->
    <div id="editCvModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h3 class="text-lg font-semibold text-white">Đổi tên CV</h3>
            </div>

            <form id="editCvForm" action="" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6">
                    <label for="cv_name_edit" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên hiển thị của CV
                    </label>
                    <input type="text" name="cv_name" id="cv_name_edit" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                        placeholder="Nhập tên CV...">
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-info-circle"></i> Tên này sẽ hiển thị để bạn dễ dàng quản lý các CV khác nhau
                    </p>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Hủy
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function handleFileSelect(input) {
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
                fileNameDisplay.innerHTML = `<i class="fas fa-check-circle"></i> Đã chọn: ${fileName} (${fileSize}MB)`;
                fileNameDisplay.classList.remove('hidden');
            } else {
                fileNameDisplay.classList.add('hidden');
            }
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(`dropdown-${id}`);
            if (dropdown.classList.contains('hidden')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    if (el.id !== `dropdown-${id}`) el.classList.add('hidden');
                });
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function openEditModal(cvId, cvName) {
            const modal = document.getElementById('editCvModal');
            const form = document.getElementById('editCvForm');
            const input = document.getElementById('cv_name_edit');

            form.action = `/candidate/cv/${cvId}/update-name`;
            input.value = cvName;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            const modal = document.getElementById('editCvModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.getElementById('editCvModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });

        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick*="toggleDropdown"]') && !event.target.closest('[id^="dropdown-"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
            }
        });
    </script>
@endsection