@extends('layouts.admin_layout')

@section('title', 'Quản lý kỹ năng | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-2xl">code</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 font-headline">Quản lý kỹ năng</h1>
                        <p class="text-gray-500 mt-1">Quản lý danh sách kỹ năng chuyên môn trên hệ thống</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Tổng số kỹ năng</p>
                    <p class="text-white text-4xl font-bold">{{ $skills->count() }}</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-3xl">sell</span>
                </div>
            </div>
        </div>

        <!-- Add New Skill Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-500">add_circle</span>
                    <h3 class="text-lg font-semibold text-gray-800">Thêm kỹ năng mới</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.skills.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên kỹ năng</label>
                        <input type="text" name="name" placeholder="VD: Laravel, React, Python, UI/UX..." required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm font-medium">
                            <span class="material-symbols-outlined text-base">add</span>
                            Thêm kỹ năng
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Skills List Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">list_alt</span>
                        <h3 class="text-lg font-semibold text-gray-800">Danh sách kỹ năng</h3>
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">{{ $skills->count() }} kỹ
                            năng</span>
                    </div>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                        <input type="text" id="searchSkill" placeholder="Tìm kiếm kỹ năng..."
                            class="pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl w-64 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mx-6 mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full" id="skillsTable">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên
                                kỹ năng</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($skills as $skill)
                            <tr class="hover:bg-gray-50/50 transition-colors skill-row"
                                data-name="{{ strtolower($skill->name) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-blue-600 text-sm">sell</span>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $skill->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="editSkill({{ $skill->id }}, '{{ $skill->name }}')"
                                            class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                            title="Chỉnh sửa">
                                            <span class="material-symbols-outlined text-base">edit</span>
                                        </button>
                                        <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST"
                                            class="inline delete-form" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all delete-btn"
                                                title="Xóa">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                </td>
                        @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="text-center">
                                            <div
                                                class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <span class="material-symbols-outlined text-gray-400 text-3xl">sell</span>
                                            </div>
                                            <h5 class="text-lg font-semibold text-gray-900 mb-2">Chưa có kỹ năng nào</h5>
                                            <p class="text-gray-500">Hãy thêm kỹ năng đầu tiên để bắt đầu</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>

            @if($skills->count() > 0)
                <div class="px-6 py-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Hiển thị {{ $skills->count() }} kỹ năng</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Skill Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa kỹ năng</h3>
                <button onclick="closeEditModal()" class="p-1 hover:bg-gray-100 rounded-lg transition">
                    <span class="material-symbols-outlined text-gray-400">close</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên kỹ năng</label>
                    <input type="text" id="skillName" name="name" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Hủy
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchSkill');
        const rows = document.querySelectorAll('.skill-row');

        function filterSkills() {
            const searchTerm = searchInput?.value.toLowerCase() || '';

            rows.forEach(row => {
                const name = row.dataset.name || '';
                if (name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput?.addEventListener('keyup', filterSkills);

        // Edit skill
        function editSkill(id, name) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const nameInput = document.getElementById('skillName');

            form.action = `/admin/skills/${id}`;
            nameInput.value = name;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Confirm delete
        function confirmDelete(event) {
            if (!confirm('Bạn có chắc chắn muốn xóa kỹ năng này không? Hành động này không thể hoàn tác.')) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        // Close modal when clicking outside
        document.getElementById('editModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
@endsection