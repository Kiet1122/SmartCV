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
                                <i class="fas fa-lock text-white text-5xl"></i>
                            </div>
                            <div class="flex justify-center gap-2 mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-white text-xl"></i>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-key text-white text-xl"></i>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Content -->
                        <div class="relative z-10">
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                                Thiết lập mật khẩu mới
                            </h2>
                            <p class="text-blue-100 text-sm md:text-base mb-6 leading-relaxed">
                                Tạo một mật khẩu mạnh để bảo vệ tài khoản của bạn
                            </p>

                            <!-- Password Tips -->
                            <div class="space-y-2 text-left mb-6">
                                <div class="flex items-center gap-3 text-blue-100">
                                    <i class="fas fa-check-circle text-green-300 text-sm"></i>
                                    <span class="text-sm">Ít nhất 8 ký tự</span>
                                </div>
                                <div class="flex items-center gap-3 text-blue-100">
                                    <i class="fas fa-check-circle text-green-300 text-sm"></i>
                                    <span class="text-sm">Kết hợp chữ hoa, chữ thường</span>
                                </div>
                                <div class="flex items-center gap-3 text-blue-100">
                                    <i class="fas fa-check-circle text-green-300 text-sm"></i>
                                    <span class="text-sm">Bao gồm số và ký tự đặc biệt</span>
                                </div>
                            </div>

                            <!-- Security Note -->
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-shield-alt text-white text-lg"></i>
                                    <p class="text-blue-50 text-xs text-left">
                                        Mật khẩu mạnh giúp bảo vệ tài khoản của bạn khỏi các nguy cơ tấn công.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Reset Password Form -->
                    <div class="p-6 md:p-8 lg:p-10">
                        <!-- Logo & Title -->
                        <div class="text-center mb-8">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fas fa-brain text-white text-2xl"></i>
                                </div>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Tạo mật khẩu mới</h1>
                            <p class="text-gray-500 text-sm">
                                Nhập mật khẩu mới cho tài khoản của bạn
                            </p>
                        </div>

                        <!-- Reset Password Form -->
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email Field (readonly) -->
                            <div class="mb-5">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-blue-500 mr-1"></i> Địa chỉ email
                                </label>
                                <input type="email" id="email" name="email" value="{{ request()->email ?? old('email') }}"
                                    required readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password Field -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock text-blue-500 mr-1"></i> Mật khẩu mới
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required autofocus
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none pr-12"
                                        placeholder="••••••••">
                                    <button type="button" onclick="togglePassword('password', 'togglePasswordIcon')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition">
                                        <i id="togglePasswordIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-check-circle text-blue-500 mr-1"></i> Xác nhận mật khẩu mới
                                </label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none pr-12"
                                        placeholder="••••••••">
                                    <button type="button"
                                        onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition">
                                        <i id="toggleConfirmIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Strength Indicator (Optional) -->
                            <div class="mb-6">
                                <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                                    <div id="passwordStrength" class="h-full w-0 transition-all duration-300 rounded-full">
                                    </div>
                                </div>
                                <p id="strengthText" class="text-xs text-gray-500 mt-1 text-center"></p>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Lưu mật khẩu & Đăng nhập
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
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);

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

        // Password strength checker (optional)
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;
                const strengthBar = document.getElementById('passwordStrength');
                const strengthText = document.getElementById('strengthText');

                let strength = 0;
                let color = '';
                let message = '';

                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;

                switch (strength) {
                    case 0:
                    case 1:
                        color = 'bg-red-500';
                        message = 'Mật khẩu yếu';
                        strengthBar.style.width = '25%';
                        break;
                    case 2:
                        color = 'bg-yellow-500';
                        message = 'Mật khẩu trung bình';
                        strengthBar.style.width = '50%';
                        break;
                    case 3:
                        color = 'bg-blue-500';
                        message = 'Mật khẩu tốt';
                        strengthBar.style.width = '75%';
                        break;
                    case 4:
                        color = 'bg-green-500';
                        message = 'Mật khẩu mạnh';
                        strengthBar.style.width = '100%';
                        break;
                }

                strengthBar.className = `h-full transition-all duration-300 rounded-full ${color}`;
                strengthText.textContent = message;
                strengthText.className = `text-xs mt-1 text-center ${color.replace('bg-', 'text-')}`;
            });
        }
    </script>
@endsection