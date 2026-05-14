@extends('layouts.recruiter_layout')

@section('title', 'Hồ sơ công ty | The Curator')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">business</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Hồ sơ công ty</h1>
                    <p class="text-gray-500 mt-1">Quản lý thông tin tuyển dụng của doanh nghiệp</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Sidebar - Company Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    <!-- Company Avatar Section -->
                    <div class="p-6 text-center border-b border-gray-100 bg-gradient-to-br from-blue-50 to-indigo-50/30">
                        <div class="relative inline-block">
                            @if($company->logo_url)
                                <div
                                    class="w-28 h-28 rounded-2xl bg-white shadow-md flex items-center justify-center overflow-hidden mx-auto">
                                    <img src="{{ asset('storage/' . $company->logo_url) }}" alt="Logo"
                                        class="w-24 h-24 object-contain">
                                </div>
                            @else
                                <div
                                    class="w-28 h-28 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md flex items-center justify-center mx-auto">
                                    <span class="material-symbols-outlined text-white text-5xl">business</span>
                                </div>
                            @endif

                            <!-- Edit Badge -->
                            <label for="logo_upload"
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-all border border-gray-200">
                                <span class="material-symbols-outlined text-blue-600 text-base">edit</span>
                            </label>
                            <input type="file" id="logo_upload" name="logo" accept="image/*" class="hidden"
                                form="companyForm">
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mt-4">{{ $company->company_name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $company->industry ?? 'Chưa cập nhật ngành nghề' }}</p>

                        <!-- Verification Badge -->
                        <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 rounded-full">
                            <span class="material-symbols-outlined text-emerald-600 text-sm"
                                style="font-variation-settings: 'FILL' 1;">verified</span>
                            <span class="text-xs text-emerald-700 font-medium">Đã xác thực</span>
                        </div>
                    </div>

                    <!-- Company Stats -->
                    <div class="p-6 space-y-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-gray-500">
                                <span class="material-symbols-outlined text-base">calendar_today</span>
                                <span class="text-sm">Tham gia</span>
                            </div>
                            <span
                                class="font-semibold text-gray-900">{{ $company->created_at ? $company->created_at->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                        </div>
                    </div>

                    <!-- Contact Info Preview -->
                    <div class="p-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">contact_support</span>
                            Thông tin liên hệ
                        </h4>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span class="material-symbols-outlined text-base">language</span>
                                <a href="{{ $company->website }}" target="_blank"
                                    class="text-blue-600 hover:underline truncate">
                                    {{ $company->website ?? 'Chưa cập nhật' }}
                                </a>
                            </div>
                            <div class="flex items-start gap-2 text-sm text-gray-500">
                                <span class="material-symbols-outlined text-base">location_on</span>
                                <span class="flex-1">{{ $company->address ?? 'Chưa cập nhật địa chỉ' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Edit Form -->
            <div class="lg:col-span-2">
                <form id="companyForm" action="{{ route('recruiter.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Hidden logo input handled by JS -->
                    <input type="file" name="logo" id="logo_input" class="hidden" accept="image/*">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Form Header -->
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-lg font-semibold text-gray-800">Thông tin cơ bản</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Cập nhật thông tin công ty của bạn</p>
                        </div>

                        <!-- Form Body -->
                        <div class="p-6 space-y-5">
                            <!-- Tên công ty -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tên công ty <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company_name"
                                    value="{{ old('company_name', $company->company_name) }}"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all @error('company_name') border-red-500 @enderror"
                                    placeholder="Nhập tên công ty" required>
                                @error('company_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email liên hệ
                                </label>

                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <span class="material-symbols-outlined text-lg">mail</span>
                                    </span>

                                    <input type="email" name="email" value="{{ old('email', $company->email) }}"
                                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all @error('email') border-red-500 @enderror"
                                        placeholder="Nhập email liên hệ" required>
                                </div>

                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <span class="material-symbols-outlined text-lg">language</span>
                                    </span>
                                    <input type="url" name="website" value="{{ old('website', $company->website) }}"
                                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                                        placeholder="https://example.com">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Lĩnh vực
                                </label>

                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <span class="material-symbols-outlined text-lg">business_center</span>
                                    </span>

                                    <input type="text" name="industry" value="{{ old('industry', $company->industry) }}"
                                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                                        placeholder="Ví dụ: Công nghệ thông tin">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Quy mô công ty
                                </label>

                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <span class="material-symbols-outlined text-lg">groups</span>
                                    </span>

                                    <input type="text" name="company_size"
                                        value="{{ old('company_size', $company->company_size) }}"
                                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all"
                                        placeholder="Ví dụ: 50-100 nhân viên">
                                </div>
                            </div>

                            <!-- Địa chỉ -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Địa chỉ công ty</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-4 text-gray-400">
                                        <span class="material-symbols-outlined text-lg">location_on</span>
                                    </span>
                                    <textarea name="address" rows="2"
                                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all resize-none"
                                        placeholder="Số nhà, đường, quận/huyện, thành phố">{{ old('address', $company->address) }}</textarea>
                                </div>
                            </div>

                            <!-- Mô tả -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Mô tả công ty</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-4 text-gray-400">
                                        <span class="material-symbols-outlined text-lg">description</span>
                                    </span>
                                    <textarea name="description" rows="5"
                                        class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all resize-none"
                                        placeholder="Giới thiệu về công ty, lĩnh vực hoạt động, văn hóa doanh nghiệp...">{{ old('description', $company->description) }}</textarea>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Tối đa 500 ký tự</p>
                            </div>
                        </div>

                        <!-- Form Footer -->
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                            <a href="{{ route('recruiter.dashboard') }}"
                                class="px-6 py-2.5 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-all">
                                Hủy bỏ
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">save</span>
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for logo upload -->
    <script>
        document.getElementById('logo_upload')?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                // Create a hidden file input in the form
                const form = document.getElementById('companyForm');
                const existingInput = form.querySelector('input[name="logo"]');
                if (existingInput) existingInput.remove();

                const input = document.createElement('input');
                input.type = 'file';
                input.name = 'logo';
                input.files = e.target.files;
                input.style.display = 'none';
                form.appendChild(input);

                // Preview image
                const reader = new FileReader();
                reader.onload = function (event) {
                    const imgContainer = document.querySelector('.w-28.h-28.rounded-2xl');
                    if (imgContainer) {
                        imgContainer.innerHTML = `<img src="${event.target.result}" alt="Logo Preview" class="w-24 h-24 object-contain">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection