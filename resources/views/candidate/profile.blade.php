@extends('layouts.candidate_layout')

@section('title', 'Hồ sơ cá nhân - SmartCV')

@section('content')
    <div class="max-w-6xl mx-auto py-6 md:py-10 px-4 sm:px-6">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Hồ sơ cá nhân</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Quản lý thông tin cá nhân của bạn</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Avatar & Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="flex flex-col items-center text-center">
                        <form action="{{ route('candidate.profile.update_avatar') }}" method="POST"
                            enctype="multipart/form-data" id="avatarForm">
                            @csrf
                            <div class="relative group">
                                <div class="avatar-box">
                                    @if(!empty($profile) && !empty($profile->avatar))
                                        <img src="{{ asset('storage/' . $profile->avatar) }}" class="avatar" alt="Avatar">
                                    @else
                                        <div class="avatar-placeholder">👤</div>
                                    @endif
                                </div>

                                <label for="avatar_upload"
                                    class="absolute bottom-1 right-1 w-8 h-8 rounded-full bg-white shadow-md border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition cursor-pointer text-gray-500 hover:text-blue-600">
                                    <i class="fas fa-camera text-sm"></i>
                                </label>
                                <input type="file" id="avatar_upload" name="avatar" class="hidden"
                                    accept="image/jpeg,image/png,image/jpg"
                                    onchange="document.getElementById('avatarForm').submit();">
                            </div>
                        </form>

                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <span
                            class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            <i class="fas fa-check-circle text-xs"></i> Ứng viên
                        </span>
                    </div>

                    <div class="border-t border-gray-100 my-6"></div>

                    <!-- Stats -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Ngày tham gia</span>
                            <span class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Mã số</span>
                            <span class="text-sm font-medium text-gray-700">#{{ $user->id }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Form -->
            <div class="lg:col-span-2">
                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 text-sm flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-red-700 text-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <span class="font-semibold">Vui lòng kiểm tra lại thông tin:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('candidate.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header -->
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Thông tin cá nhân</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Những thông tin này sẽ được hiển thị trên CV của bạn</p>
                        </div>

                        <!-- Body -->
                        <div class="p-6 space-y-5">
                            <!-- 2 Columns Layout for Name & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Họ và tên <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-sm">
                                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Địa chỉ Email</label>
                                    <input type="email" value="{{ $user->email }}" readonly
                                        class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 text-sm cursor-not-allowed">
                                    <p class="mt-1 text-xs text-gray-400">Email không thể thay đổi</p>
                                </div>
                            </div>

                            <!-- Phone & Address -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Số điện thoại</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $profile->phone ?? '') }}"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-sm"
                                        placeholder="0123 456 789">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Địa chỉ</label>
                                    <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}"
                                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-sm"
                                        placeholder="TP. Hồ Chí Minh, Việt Nam">
                                </div>
                            </div>

                            <!-- Bio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Giới thiệu ngắn</label>
                                <textarea name="bio" rows="5"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-sm resize-none"
                                    placeholder="Chia sẻ một chút về kinh nghiệm, thế mạnh hoặc mục tiêu nghề nghiệp của bạn...">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                <p class="mt-1 text-xs text-gray-400 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i> Thông tin này giúp nhà tuyển dụng hiểu rõ hơn về bạn
                                </p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
                            <a href="{{ route('candidate.dashboard') }}"
                                class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                Hủy bỏ
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                                <i class="fas fa-save text-sm"></i>
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection