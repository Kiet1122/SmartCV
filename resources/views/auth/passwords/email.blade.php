@extends('layouts.master')

@section('content')
    <section
        class="min-h-screen flex items-center justify-center py-16 bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="max-w-6xl w-full mx-auto px-5 sm:px-8">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2">
                    <!-- Left Side - Banner/Image -->
                    <div
                        class="relative bg-gradient-to-br from-blue-600 to-indigo-700 p-8 md:p-12 flex flex-col justify-center items-center text-center">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

                        <!-- Illustration -->
                        <div class="relative z-10 mb-8">
                            <div
                                class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                                <i class="fas fa-key text-white text-5xl"></i>
                            </div>
                            <div class="flex justify-center gap-2 mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-lock text-white text-xl"></i>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Content -->
                        <div class="relative z-10">
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                                Quên mật khẩu?
                            </h2>
                            <p class="text-blue-100 text-sm md:text-base mb-6 leading-relaxed">
                                Đừng lo lắng! Chúng tôi sẽ giúp bạn lấy lại tài khoản một cách nhanh chóng.
                            </p>

                            <!-- Steps -->
                            <div class="space-y-3 text-left mb-6">
                                <div class="flex items-center gap-3 text-blue-100">
                                    <div
                                        class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">
                                        1</div>
                                    <span class="text-sm">Nhập email đã đăng ký</span>
                                </div>
                                <div class="flex items-center gap-3 text-blue-100">
                                    <div
                                        class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">
                                        2</div>
                                    <span class="text-sm">Kiểm tra hộp thư đến</span>
                                </div>
                                <div class="flex items-center gap-3 text-blue-100">
                                    <div
                                        class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center text-xs font-bold">
                                        3</div>
                                    <span class="text-sm">Đặt lại mật khẩu mới</span>
                                </div>
                            </div>

                            <!-- Security Note -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-shield-alt text-white text-lg"></i>
                                    <p class="text-blue-50 text-xs text-left">
                                        Link đặt lại mật khẩu sẽ có hiệu lực trong vòng 60 phút.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Forgot Password Form -->
                    <div class="p-6 md:p-8 lg:p-10">
                        <!-- Logo & Title -->
                        <div class="text-center mb-8">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-brain text-white text-2xl"></i>
                                </div>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Quên mật khẩu?</h1>
                            <p class="text-gray-500 text-sm">
                                Nhập email của bạn để nhận hướng dẫn đặt lại mật khẩu
                            </p>
                        </div>

                        <!-- Success Message -->
                        @if (session('status'))
                            <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            {{ session('status') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Forgot Password Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-blue-500 mr-1"></i> Địa chỉ email
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                    placeholder="example@smartcv.ai">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i> Gửi link đặt lại mật khẩu
                            </button>

                            <!-- Back to Login Link -->
                            <div class="mt-6 text-center">
                                <a href="{{ route('login') }}"
                                    class="text-sm text-gray-600 hover:text-blue-600 transition flex items-center justify-center gap-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Quay lại trang đăng nhập
                                </a>
                            </div>
                        </form>

                        <!-- Contact Support -->
                        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-headset"></i> Cần hỗ trợ?
                                <a href="{{ url('/contact') }}" class="text-blue-600 hover:underline">Liên hệ chúng tôi</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection