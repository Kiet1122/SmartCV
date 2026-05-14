@extends('layouts.candidate_layout')

@section('content')
    <main class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Việc làm đã lưu</h1>
            <p class="mt-1 text-sm text-gray-500">Danh sách các cơ hội nghề nghiệp mà bạn đang quan tâm.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow sm:rounded-xl border border-gray-100 overflow-hidden">

            @if($savedJobs->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($savedJobs as $job)
                        <li class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-4">
                                    <div
                                        class="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border border-gray-200">
                                        <i class="fa-solid fa-building text-2xl"></i>
                                    </div>

                                    <div>
                                        @foreach($savedJobs as $job)
                                            <h3 class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                                                <a href="{{ route('candidate.jobs.show', $job->id) }}">
                                                    {{ $job->title }}
                                                </a>
                                            </h3>
                                        @endforeach
                                        <p class="text-sm font-medium text-gray-900 mt-1">
                                            {{ $job->company->company_name ?? 'Công ty ẩn danh' }}
                                        </p>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                            <span><i class="fa-solid fa-money-bill-wave mr-1"></i>
                                                {{ $job->salary_range ?? 'Thỏa thuận' }}</span>
                                            <span><i class="fa-solid fa-briefcase mr-1"></i> {{ $job->experience_required }} năm
                                                KN</span>
                                            <span><i class="fa-regular fa-clock mr-1"></i> Đã lưu:
                                                {{ \Carbon\Carbon::parse($job->pivot->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 items-end">
                                    <button
                                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                        Ứng tuyển ngay
                                    </button>

                                    <form action="{{ route('candidate.saved_jobs.toggle', $job->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can"></i> Bỏ lưu
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $savedJobs->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                        <i class="fa-regular fa-bookmark text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Chưa có việc làm nào được lưu</h3>
                    <p class="mt-2 text-sm text-gray-500">Hãy lướt xem các danh sách việc làm và lưu lại những cơ hội phù hợp
                        với bạn nhé.</p>
                    <div class="mt-6">
                        <a href="/"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Khám phá việc làm
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </main>
@endsection