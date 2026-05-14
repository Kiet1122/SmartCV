@extends('layouts.admin_layout')

@section('title', 'Quản lý người dùng | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 font-headline">Quản lý người dùng</h1>
                <p class="text-gray-500 mt-1">Quản lý tất cả tài khoản người dùng trên hệ thống</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-base">add</span>
                    Thêm người dùng
                </button>
                <button
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-base">download</span>
                    Xuất Excel
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Tổng người dùng</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-500">group</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ứng viên</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'candidate')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-500">person</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Nhà tuyển dụng</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'recruiter')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-purple-500">business</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Admin</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-amber-500">admin_panel_settings</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="flex flex-col md:flex-row justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên, email..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
            </div>
            <div class="flex gap-3">
                <select id="roleFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📋 Tất cả vai trò</option>
                    <option value="candidate">👤 Ứng viên</option>
                    <option value="recruiter">🏢 Nhà tuyển dụng</option>
                    <option value="admin">⚙️ Quản trị viên</option>
                </select>
                <select id="statusFilter"
                    class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">📌 Tất cả trạng thái</option>
                    <option value="active">🟢 Hoạt động</option>
                    <option value="inactive">🔴 Không hoạt động</option>
                </select>
                <button id="resetFilters"
                    class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all">
                    <span class="material-symbols-outlined text-base align-middle">refresh</span>
                    Đặt lại
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full" id="usersTable">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Người dùng</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Vai
                                trò</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Trạng thái</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngày tham gia</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="usersTableBody">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors user-row" data-name="{{ strtolower($user->name) }}"
                                data-email="{{ strtolower($user->email) }}" data-role="{{ $user->role }}">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $roleConfig = [
                                            'admin' => ['class' => 'bg-purple-100 text-purple-700', 'icon' => 'admin_panel_settings', 'text' => 'Quản trị viên'],
                                            'recruiter' => ['class' => 'bg-blue-100 text-blue-700', 'icon' => 'business', 'text' => 'Nhà tuyển dụng'],
                                            'candidate' => ['class' => 'bg-green-100 text-green-700', 'icon' => 'person', 'text' => 'Ứng viên'],
                                        ];
                                        $config = $roleConfig[$user->role] ?? $roleConfig['candidate'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                        <span class="material-symbols-outlined text-sm">{{ $config['icon'] }}</span>
                                        {{ $config['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Hoạt động
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                    <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="viewUser({{ $user->id }})"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                            title="Xem chi tiết">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                    <span class="material-symbols-outlined text-4xl mb-2">person_off</span>
                                    <p>Chưa có người dùng nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($users, 'links') && $users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <div id="userModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden transition-all transform">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Thông tin chi tiết</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-6" id="modalBody">
                <div class="flex justify-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                </div>
            </div>

            <div class="px-6 py-4 border-t bg-gray-50 text-right">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-medium">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        // Search and Filter functionality
        const searchInput = document.getElementById('searchInput');
        const roleFilter = document.getElementById('roleFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetFilters');
        const rows = document.querySelectorAll('.user-row');

        function viewUser(id) {
            const modal = document.getElementById('userModal');
            const body = document.getElementById('modalBody');

            // 1. Hiện modal
            modal.classList.remove('hidden');
            body.innerHTML = '<p class="text-center py-4 text-gray-500">Đang tải dữ liệu...</p>';

            // 2. Fetch API (Đảm bảo URL này khớp với Route của bạn)
            fetch(`/admin/users/${id}`)
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        const user = res.data;

                        // 3. Tạo giao diện từ dữ liệu JSON
                        let html = `
                            <div class="space-y-4">
                                <div class="flex justify-between border-b pb-2">
                                    <span class="text-gray-500">Họ tên</span>
                                    <span class="font-semibold text-gray-900">${user.name}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="text-gray-500">Email</span>
                                    <span class="font-semibold text-gray-900">${user.email}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="text-gray-500">Vai trò</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-bold uppercase">${user.role}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="text-gray-500">Ngày tham gia</span>
                                    <span class="font-semibold text-gray-900">${user.created_at}</span>
                                </div>
                        `;

                        // Nếu là Ứng viên hoặc Nhà tuyển dụng có thông tin chi tiết
                        if (user.details) {
                            html += `<div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-100">`;
                            for (const [key, value] of Object.entries(user.details)) {
                                let label = key.replace('_', ' ').toUpperCase();
                                html += `<p class="text-sm mb-1"><strong class="text-gray-600">${label}:</strong> ${value || 'N/A'}</p>`;
                            }
                            html += `</div>`;
                        } else {
                            html += `<p class="text-xs text-center text-gray-400 italic mt-4">Không có hồ sơ bổ sung (Admin)</p>`;
                        }

                        html += `</div>`;
                        body.innerHTML = html;
                    }
                })
                .catch(error => {
                    body.innerHTML = '<p class="text-red-500 text-center">Không thể tải dữ liệu. Vui lòng thử lại.</p>';
                    console.error('Error:', error);
                });
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        // Đóng modal khi click ra ngoài vùng box
        window.onclick = function (event) {
            const modal = document.getElementById('userModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        function filterUsers() {
            const searchTerm = searchInput?.value.toLowerCase() || '';
            const role = roleFilter?.value || 'all';
            const status = statusFilter?.value || 'all';

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const userRole = row.dataset.role || '';

                let show = true;

                // Search filter
                if (searchTerm && !name.includes(searchTerm) && !email.includes(searchTerm)) {
                    show = false;
                }

                // Role filter
                if (show && role !== 'all' && userRole !== role) {
                    show = false;
                }

                // Status filter (tạm thời chưa có status trong data)
                // Có thể thêm data-status nếu cần

                row.style.display = show ? '' : 'none';
            });
        }

        searchInput?.addEventListener('keyup', filterUsers);
        roleFilter?.addEventListener('change', filterUsers);
        statusFilter?.addEventListener('change', filterUsers);

        resetBtn?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (roleFilter) roleFilter.value = 'all';
            if (statusFilter) statusFilter.value = 'all';
            filterUsers();
        });

        // Delete modal functions
        let deleteUserId = null;

        function deleteUser(id, name) {
            deleteUserId = id;
            const modal = document.getElementById('deleteModal');
            const userNameSpan = document.getElementById('deleteUserName');
            const deleteForm = document.getElementById('deleteForm');

            userNameSpan.textContent = name;
            deleteForm.action = `/admin/users/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            deleteUserId = null;
        }

        function viewUser(id) {
            window.location.href = `/admin/users/${id}`;
        }

        function editUser(id) {
            window.location.href = `/admin/users/${id}/edit`;
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>

    @push('styles')
        <style>
            .user-row {
                transition: all 0.2s ease;
            }
        </style>
    @endpush
@endsection