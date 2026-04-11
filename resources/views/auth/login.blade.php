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
                                <i class="fas fa-brain text-white text-5xl"></i>
                            </div>
                            <div class="flex justify-center gap-2 mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-file-alt text-white text-xl"></i>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-xl"></i>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-briefcase text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Content -->
                        <div class="relative z-10">
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                                Kết nối việc làm thông minh
                            </h2>
                            <p class="text-blue-100 text-sm md:text-base mb-6 leading-relaxed">
                                Hơn 100.000+ ứng viên đã tìm được việc làm mơ ước cùng SmartCV
                            </p>

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div>
                                    <div class="text-2xl font-bold text-white">500+</div>
                                    <div class="text-xs text-blue-100">Doanh nghiệp</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">100K+</div>
                                    <div class="text-xs text-blue-100">Ứng viên</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">98%</div>
                                    <div class="text-xs text-blue-100">Tỷ lệ phù hợp</div>
                                </div>
                            </div>

                            <!-- Testimonial -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-full bg-white/30 flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-white text-sm font-semibold">Nguyễn Văn A</p>
                                        <p class="text-blue-100 text-xs">Frontend Developer</p>
                                    </div>
                                </div>
                                <p class="text-blue-50 text-sm italic">
                                    "SmartCV giúp tôi tìm được công việc mơ ước chỉ sau 2 tuần!"
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="p-6 md:p-8 lg:p-10">
                        <!-- Logo & Title -->
                        <div class="text-center mb-6">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-brain text-white text-2xl"></i>
                                </div>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Đăng nhập</h1>
                            <p class="text-gray-500 text-sm">Chào mừng bạn quay trở lại!</p>
                        </div>

                        <!-- Login Form -->
                        <form action="#" method="POST">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-blue-500 mr-1"></i> Email
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                    placeholder="example@smartcv.ai">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock text-blue-500 mr-1"></i> Mật khẩu
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none pr-12"
                                        placeholder="Nhập mật khẩu">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition">
                                        <i id="togglePasswordIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex justify-between items-center mb-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remember"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-600">Ghi nhớ đăng nhập</span>
                                </label>
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 hover:underline transition">
                                    Quên mật khẩu?
                                </a>
                            </div>

                            <!-- Login Button -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </button>

                            <!-- Social Login Buttons -->
                            <div class="mt-6">
                                <!-- Divider -->
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-2 bg-white text-gray-500">Hoặc đăng nhập với</span>
                                    </div>
                                </div>

                                <!-- Google Button -->
                                <div class="mt-6">
                                    <a href="{{ route('auth.google.redirect') }}"
                                        class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">

                                        <!-- Icon Google -->
                                        <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24">
                                            <path d="M22.56 12.25..." fill="#4285F4" />
                                            <path d="M12 23..." fill="#34A853" />
                                            <path d="M5.84 14.09..." fill="#FBBC05" />
                                            <path d="M12 5.38..." fill="#EA4335" />
                                        </svg>

                                        Đăng nhập bằng Google
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Register Link -->
                        <p class="text-center text-gray-600 mt-6 text-sm">
                            Chưa có tài khoản?
                            <a href="#" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline transition">
                                Đăng ký ngay
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection