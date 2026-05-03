@extends('layouts.recruiter_layout')

@section('title', isset($job) ? 'Chỉnh sửa tin tuyển dụng | The Curator' : 'Đăng tin tuyển dụng | The Curator')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center">
            <span class="material-symbols-outlined text-blue-600 text-3xl">{{ isset($job) ? 'edit' : 'post_add' }}</span>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ isset($job) ? 'Chỉnh sửa tin tuyển dụng' : 'Đăng tin tuyển dụng mới' }}</h1>
            <p class="text-gray-500">{{ isset($job) ? 'Cập nhật thông tin vị trí đang tuyển' : 'Tạo cơ hội việc làm mới cho ứng viên' }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ isset($job) ? route('recruiter.jobs.update', $job->id) : route('recruiter.jobs.store') }}" method="POST">
                @csrf
                @if(isset($job)) @method('PUT') @endif

                <!-- Tiêu đề công việc -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tiêu đề công việc <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center bg-gray-50 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-all">
                        <div class="px-3 text-gray-400">
                            <span class="material-symbols-outlined text-xl">work</span>
                        </div>
                        <input type="text" 
                               name="title" 
                               class="flex-1 bg-transparent py-3 pr-3 outline-none text-gray-800 placeholder-gray-400 @error('title') border-red-500 @enderror" 
                               value="{{ $job->title ?? old('title') }}" 
                               placeholder="VD: Senior Fullstack Developer" 
                               required>
                    </div>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả công việc -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mô tả công việc</label>
                    <div class="flex bg-gray-50 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-all">
                        <div class="px-3 pt-3 text-gray-400">
                            <span class="material-symbols-outlined text-xl">description</span>
                        </div>
                        <textarea name="description" 
                                  rows="6" 
                                  class="flex-1 bg-transparent py-3 pr-3 outline-none text-gray-800 placeholder-gray-400 resize-none"
                                  placeholder="Mô tả chi tiết về công việc, trách nhiệm, yêu cầu...">{{ $job->description ?? old('description') }}</textarea>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Mô tả càng chi tiết càng thu hút ứng viên chất lượng</p>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2 cột: Kinh nghiệm và Mức lương -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kinh nghiệm yêu cầu</label>
                        <div class="flex items-center bg-gray-50 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-all">
                            <div class="px-3 text-gray-400">
                                <span class="material-symbols-outlined text-xl">timeline</span>
                            </div>
                            <input type="number" 
                                   step="0.5" 
                                   name="experience_required" 
                                   class="flex-1 bg-transparent py-3 pr-3 outline-none text-gray-800 placeholder-gray-400" 
                                   value="{{ $job->experience_required ?? old('experience_required') }}" 
                                   placeholder="Số năm">
                            <div class="px-3 text-gray-400 text-sm">năm</div>
                        </div>
                        @error('experience_required')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mức lương</label>
                        <div class="flex items-center bg-gray-50 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-all">
                            <div class="px-3 text-gray-400">
                                <span class="material-symbols-outlined text-xl">payments</span>
                            </div>
                            <input type="text" 
                                   name="salary_range" 
                                   class="flex-1 bg-transparent py-3 pr-3 outline-none text-gray-800 placeholder-gray-400" 
                                   value="{{ $job->salary_range ?? old('salary_range') }}" 
                                   placeholder="VD: 15-25 triệu hoặc Thỏa thuận">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Có thể ghi "Thỏa thuận" nếu chưa xác định</p>
                        @error('salary_range')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Trình độ yêu cầu -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Trình độ yêu cầu</label>
                    <div class="flex items-center bg-gray-50 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-all">
                        <div class="px-3 text-gray-400">
                            <span class="material-symbols-outlined text-xl">school</span>
                        </div>
                        <select name="education_required" class="flex-1 bg-transparent py-3 pr-3 outline-none text-gray-800">
                            <option value="">-- Chọn trình độ --</option>
                            <option value="Không yêu cầu" {{ (isset($job) && $job->education_required == 'Không yêu cầu') ? 'selected' : '' }}>Không yêu cầu</option>
                            <option value="Trung cấp" {{ (isset($job) && $job->education_required == 'Trung cấp') ? 'selected' : '' }}>Trung cấp</option>
                            <option value="Cao đẳng" {{ (isset($job) && $job->education_required == 'Cao đẳng') ? 'selected' : '' }}>Cao đẳng</option>
                            <option value="Đại học" {{ (isset($job) && $job->education_required == 'Đại học') ? 'selected' : '' }}>Đại học</option>
                            <option value="Sau đại học" {{ (isset($job) && $job->education_required == 'Sau đại học') ? 'selected' : '' }}>Sau đại học</option>
                        </select>
                    </div>
                    @error('education_required')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kỹ năng yêu cầu -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kỹ năng yêu cầu</label>
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($skills as $skill)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           name="skills[]" 
                                           value="{{ $skill->id }}" 
                                           class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                           {{ (isset($selectedSkills) && in_array($skill->id, $selectedSkills)) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">{{ $skill->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Chọn các kỹ năng cần thiết cho vị trí này</p>
                    @error('skills')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái và Nút hành động -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-100">
                    <div class="flex gap-3">
                        <a href="{{ route('recruiter.jobs.index') }}" class="px-5 py-2.5 text-gray-600 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                            Hủy bỏ
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">{{ isset($job) ? 'save' : 'send' }}</span>
                            {{ isset($job) ? 'Cập nhật tin' : 'Đăng tin ngay' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection