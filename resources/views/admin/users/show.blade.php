@extends('layouts.admin_layout')

@section('title', 'Chi tiết tài khoản | Admin Console')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Back Button -->
        <div>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Quay lại danh sách người dùng</span>
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Header with Gradient -->
            <div class="relative px-6 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-6xl">person</span>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                            @php
                                $roleIcon = match ($user->role) {
                                    'admin' => 'admin_panel_settings',
                                    'recruiter' => 'business',
                                    default => 'person'
                                };
                            @endphp
                            <span class="material-symbols-outlined text-white text-3xl">{{ $roleIcon }}</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h1>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-blue-100 text-sm">ID: #{{ $user->id }}</span>
                                <span class="w-1 h-1 bg-blue-300 rounded-full"></span>
                                <span class="text-blue-100 text-sm">{{ $user->email }}</span>
                                <span class="w-1 h-1 bg-blue-300 rounded-full"></span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                                    {{ $user->role === 'candidate' ? 'Ứng viên' : ($user->role === 'recruiter' ? 'Nhà tuyển dụng' : 'Quản trị viên') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Left Column - System Info -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-600 text-base">computer</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Thông tin hệ thống</h3>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-blue-500 text-sm">badge</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 uppercase font-semibold">Họ tên</p>
                                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-blue-500 text-sm">mail</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 uppercase font-semibold">Email</p>
                                    <p class="font-medium text-gray-800">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                                    <span
                                        class="material-symbols-outlined text-blue-500 text-sm">admin_panel_settings</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 uppercase font-semibold">Vai trò</p>
                                    <div class="flex items-center gap-3 mt-1">
                                        @php
                                            $roleConfig = [
                                                'admin' => ['class' => 'bg-purple-100 text-purple-700', 'text' => 'Quản trị viên'],
                                                'recruiter' => ['class' => 'bg-blue-100 text-blue-700', 'text' => 'Nhà tuyển dụng'],
                                                'candidate' => ['class' => 'bg-green-100 text-green-700', 'text' => 'Ứng viên'],
                                            ];
                                            $config = $roleConfig[$user->role] ?? $roleConfig['candidate'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                            <span class="material-symbols-outlined text-sm">{{ $roleIcon }}</span>
                                            {{ $config['text'] }}
                                        </span>

                                        <!-- Change Role Button -->
                                        @if($user->role !== 'admin')
                                            <button onclick="openRoleModal({{ $user->id }}, '{{ $user->role }}')"
                                                class="text-xs text-blue-600 hover:text-blue-700 hover:underline">
                                                Chuyển đổi vai trò
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-blue-500 text-sm">calendar_today</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 uppercase font-semibold">Ngày tham gia</p>
                                    <p class="font-medium text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Profile Details -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                <span class="material-symbols-outlined text-green-600 text-base">assignment_ind</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Thông tin hồ sơ</h3>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5">
                            @if(count($extraDetails) > 0)
                                <div class="space-y-4">
                                    @foreach($extraDetails as $label => $value)
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                                                @php
                                                    $icon = match ($label) {
                                                        'Tên công ty', 'Công ty' => 'business',
                                                        'Số điện thoại' => 'phone',
                                                        'Địa chỉ' => 'location_on',
                                                        'Website' => 'language',
                                                        'Mô tả', 'Giới thiệu', 'Bio' => 'description',
                                                        'Ngành nghề', 'Lĩnh vực' => 'category',
                                                        'Quy mô' => 'group',
                                                        'Ngày cập nhật hồ sơ' => 'update',
                                                        default => 'info'
                                                    };
                                                @endphp
                                                <span class="material-symbols-outlined text-green-500 text-sm">{{ $icon }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-400 uppercase font-semibold">{{ $label }}</p>
                                                @if($label === 'Website' && $value && $value !== 'N/A')
                                                    <a href="{{ $value }}" target="_blank"
                                                        class="font-medium text-blue-600 hover:underline">{{ $value }}</a>
                                                @elseif(($label === 'Mô tả' || $label === 'Giới thiệu' || $label === 'Bio') && $value && $value !== 'Chưa có dữ liệu')
                                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($value, 200) }}</p>
                                                @else
                                                    <p class="font-medium text-gray-800">{{ $value ?: 'Chưa cập nhật' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div
                                        class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                        <span class="material-symbols-outlined text-gray-400 text-2xl">info</span>
                                    </div>
                                    <p class="text-gray-400 italic">Chưa có thông tin hồ sơ chi tiết</p>
                                    <p class="text-sm text-gray-400 mt-1">Người dùng này chưa cập nhật hồ sơ</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                <div class="flex flex-wrap gap-3">
                    @if($user->role !== 'admin')
                        <button
                            class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all shadow-sm font-medium">
                            <span class="material-symbols-outlined text-base">lock_reset</span>
                            Đặt lại mật khẩu
                        </button>

                        <button
                            class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all shadow-sm font-medium">
                            <span class="material-symbols-outlined text-base">block</span>
                            Khóa tài khoản
                        </button>
                    @else
                        <button
                            class="flex items-center gap-2 px-5 py-2.5 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed"
                            disabled>
                            <span class="material-symbols-outlined text-base">lock</span>
                            Không thể khóa Admin
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Change Role Modal -->
    <div id="roleModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500">swap_horiz</span>
                    <h3 class="text-xl font-bold text-gray-900">Chuyển đổi vai trò</h3>
                </div>
                <button onclick="closeRoleModal()" class="p-1 hover:bg-gray-100 rounded-lg transition">
                    <span class="material-symbols-outlined text-gray-400">close</span>
                </button>
            </div>

            <form id="roleForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Chọn vai trò mới</label>
                    <select name="role" id="newRole"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                        <option value="candidate">👤 Ứng viên</option>
                        <option value="recruiter">🏢 Nhà tuyển dụng</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-2">
                        <span class="material-symbols-outlined text-xs align-middle">info</span>
                        Khi chuyển từ ứng viên sang nhà tuyển dụng, hệ thống sẽ tự động tạo hồ sơ công ty.
                    </p>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeRoleModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Hủy
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Xác nhận
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let userId = null;

        function openRoleModal(id, currentRole) {
            userId = id;
            const modal = document.getElementById('roleModal');
            const form = document.getElementById('roleForm');
            const select = document.getElementById('newRole');

            // Set form action
            form.action = `/admin/users/${id}/change-role`;

            // Preselect the other role
            if (currentRole === 'candidate') {
                select.value = 'recruiter';
            } else if (currentRole === 'recruiter') {
                select.value = 'candidate';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRoleModal() {
            const modal = document.getElementById('roleModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            userId = null;
        }

        // Close modal when clicking outside
        document.getElementById('roleModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeRoleModal();
            }
        });
    </script>
@endsection