@extends('layouts.master')

@section('content')
<section class="min-h-screen flex items-center justify-center py-16 bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="max-w-6xl w-full mx-auto px-5 sm:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <!-- Left Side - Banner/Image -->
                <div class="relative bg-gradient-to-br from-blue-600 to-indigo-700 p-8 md:p-12 flex flex-col justify-center items-center text-center">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    
                    <!-- Illustration -->
                    <div class="relative z-10 mb-8">
                        <div class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
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
                            Tham gia cùng chúng tôi
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
                                    <p class="text-white text-sm font-semibold">Nguyễn Thị B</p>
                                    <p class="text-blue-100 text-xs">Product Manager</p>
                                </div>
                            </div>
                            <p class="text-blue-50 text-sm italic">
                                "SmartCV giúp tôi tìm được công việc mơ ước chỉ sau 2 tuần!"
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Register Form -->
                <div class="p-6 md:p-8 lg:p-10">
                    <!-- Logo & Title -->
                    <div class="text-center mb-6">
                        <div class="flex justify-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-brain text-white text-2xl"></i>
                            </div>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Tạo tài khoản</h1>
                        <p class="text-gray-500 text-sm">Bắt đầu hành trình tìm kiếm việc làm của bạn</p>
                    </div>

                    <!-- Register Form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Role Selection -->
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-user-tag text-blue-500 mr-1"></i> Bạn là?
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <input type="radio" name="role" id="role_candidate" value="candidate" class="peer hidden" {{ old('role', 'candidate') == 'candidate' ? 'checked' : '' }}>
                                    <label for="role_candidate"
                                        class="flex flex-col items-center justify-center cursor-pointer rounded-xl border-2 border-gray-200 bg-white p-3 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                        <i class="fas fa-user-graduate text-blue-500 text-xl mb-1"></i>
                                        <span class="text-sm font-semibold text-gray-900">Ứng viên</span>
                                        <span class="text-xs text-gray-500">Tìm việc</span>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" name="role" id="role_recruiter" value="recruiter" class="peer hidden" {{ old('role') == 'recruiter' ? 'checked' : '' }}>
                                    <label for="role_recruiter"
                                        class="flex flex-col items-center justify-center cursor-pointer rounded-xl border-2 border-gray-200 bg-white p-3 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                        <i class="fas fa-building text-blue-500 text-xl mb-1"></i>
                                        <span class="text-sm font-semibold text-gray-900">Nhà tuyển dụng</span>
                                        <span class="text-xs text-gray-500">Đăng tin</span>
                                    </label>
                                </div>
                            </div>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-blue-500 mr-1"></i> Họ và tên
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                placeholder="Nguyễn Văn A">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-blue-500 mr-1"></i> Địa chỉ email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none"
                                placeholder="example@smartcv.ai">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-blue-500 mr-1"></i> Mật khẩu
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
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

                        <!-- Confirm Password -->
                        <div class="mb-5">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-check-circle text-blue-500 mr-1"></i> Xác nhận mật khẩu
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none pr-12"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition">
                                    <i id="toggleConfirmIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="mb-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="terms" required
                                    class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-sm text-gray-600">
                                    Tôi đồng ý với 
                                    <a href="#" class="text-blue-600 hover:underline">Điều khoản sử dụng</a> 
                                    và 
                                    <a href="#" class="text-blue-600 hover:underline">Chính sách bảo mật</a>
                                </span>
                            </label>
                            @error('terms')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Register Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i> Tạo tài khoản
                        </button>

                        <!-- Social Register -->
                        <div class="mt-6">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-2 bg-white text-gray-500">Hoặc đăng ký với</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('auth.google.redirect') }}"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" width="20" height="20">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>
                                    Đăng ký bằng Google
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <p class="text-center text-gray-600 mt-6 text-sm">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline transition">
                            Đăng nhập ngay
                        </a>
                    </p>
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
</script>
@endsection