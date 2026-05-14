@extends('layouts.admin_layout')

@section('title', 'Quản lý ngôn ngữ | Admin Console')

@section('content')
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-2xl">language</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 font-headline">Quản lý ngôn ngữ</h1>
                        <p class="text-gray-500 mt-1">Quản lý danh sách ngôn ngữ trên hệ thống</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm">Tổng số ngôn ngữ</p>
                    <p class="text-white text-4xl font-bold">{{ $languages->count() }}</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-3xl">translate</span>
                </div>
            </div>
        </div>

        <!-- Add New Language Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">add_circle</span>
                    <h3 class="text-lg font-semibold text-gray-800">Thêm ngôn ngữ mới</h3>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.languages.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên ngôn ngữ</label>
                        <input type="text" name="name" placeholder="VD: Tiếng Việt, English, 日本語, 中文..." required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all shadow-sm font-medium">
                            <span class="material-symbols-outlined text-base">add</span>
                            Thêm ngôn ngữ
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Languages List Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-500">list_alt</span>
                        <h3 class="text-lg font-semibold text-gray-800">Danh sách ngôn ngữ</h3>
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">{{ $languages->count() }}
                            ngôn ngữ</span>
                    </div>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-base">search</span>
                        <input type="text" id="searchLanguage" placeholder="Tìm kiếm ngôn ngữ..."
                            class="pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-xl w-64 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all">
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
                <table class="w-full" id="languagesTable">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngôn ngữ</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($languages as $lang)
                            <tr class="hover:bg-gray-50/50 transition-colors language-row"
                                data-name="{{ strtolower($lang->name) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center">
                                            @php
                                                $flagIcon = match (true) {
                                                    str_contains(strtolower($lang->name), 'việt') => '🇻🇳',
                                                    str_contains(strtolower($lang->name), 'english') => '🇬🇧',
                                                    str_contains(strtolower($lang->name), 'nhật') => '🇯🇵',
                                                    str_contains(strtolower($lang->name), 'trung') => '🇨🇳',
                                                    str_contains(strtolower($lang->name), 'hàn') => '🇰🇷',
                                                    str_contains(strtolower($lang->name), 'pháp') => '🇫🇷',
                                                    str_contains(strtolower($lang->name), 'đức') => '🇩🇪',
                                                    default => '🌐'
                                                };
                                            @endphp
                                            <span class="text-lg">{{ $flagIcon }}</span>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $lang->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="editLanguage({{ $lang->id }}, '{{ $lang->name }}')"
                                            class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                            title="Chỉnh sửa">
                                            <span class="material-symbols-outlined text-base">edit</span>
                                        </button>
                                        <form action="{{ route('admin.languages.destroy', $lang->id) }}" method="POST"
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <div
                                            class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-gray-400 text-3xl">translate</span>
                                        </div>
                                        <h5 class="text-lg font-semibold text-gray-900 mb-2">Chưa có ngôn ngữ nào</h5>
                                        <p class="text-gray-500">Hãy thêm ngôn ngữ đầu tiên để bắt đầu</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($languages->count() > 0)
                <div class="px-6 py-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">Hiển thị {{ $languages->count() }} ngôn ngữ</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Language Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">edit</span>
                    <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa ngôn ngữ</h3>
                </div>
                <button onclick="closeEditModal()" class="p-1 hover:bg-gray-100 rounded-lg transition">
                    <span class="material-symbols-outlined text-gray-400">close</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên ngôn ngữ</label>
                    <input type="text" id="languageName" name="name" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all">
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Hủy
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchLanguage');
        const rows = document.querySelectorAll('.language-row');

        function filterLanguages() {
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

        searchInput?.addEventListener('keyup', filterLanguages);

        // Edit language
        function editLanguage(id, name) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const nameInput = document.getElementById('languageName');

            form.action = `/admin/languages/${id}`;
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
            if (!confirm('Bạn có chắc chắn muốn xóa ngôn ngữ này không? Hành động này không thể hoàn tác.')) {
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