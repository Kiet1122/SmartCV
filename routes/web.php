<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Khách vãng lai ai cũng xem được)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/public/
*/

Route::get('/', fn() => view('public.home'))->name('home');

Route::get('/', function () {
    return view('public.home');
})->name('home');
Route::get('/jobs', function () {
    return view('public.jobs_list');
})->name('jobs.index');
Route::get('/jobs/detail', function () {
    return view('public.job_detail');
})->name('jobs.show'); // Tạm thời hardcode, sau này sẽ là /jobs/{id}
Route::get('/companies', function () {
    return view('public.companies');
})->name('companies.index');
Route::get('/about', function () {
    return view('public.about');
})->name('about');
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

/*
|--------------------------------------------------------------------------
| 2. AUTH ROUTES (Xác thực người dùng)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/auth/
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->name('password.request');
Route::get('/reset-password', function () {
    return view('auth.passwords.reset');
})->name('password.reset');

/*
|--------------------------------------------------------------------------
| 3. CANDIDATE ROUTES (Phân hệ Ứng viên)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/candidate/
| Lưu ý: Sau này sẽ thêm Middleware `auth` và kiểm tra Role = Candidate vào Group này
*/
Route::prefix('candidate')->name('candidate.')->group(function () {
    Route::get('/dashboard', function () {
        return view('candidate.dashboard');
    })->name('dashboard');
    Route::get('/profile', function () {
        return view('candidate.profile');
    })->name('profile');
    Route::get('/saved-jobs', function () {
        return view('candidate.saved_jobs');
    })->name('saved_jobs');

    // Quản lý CV
    Route::get('/cv', function () {
        return view('candidate.cv.index');
    })->name('cv.index');
    Route::get('/cv/review', function () {
        return view('candidate.cv.review_parsed_data');
    })->name('cv.review');

    // Lịch sử ứng tuyển & Gợi ý
    Route::get('/applications', function () {
        return view('candidate.applications.index');
    })->name('applications.index');
    Route::get('/recommendations', function () {
        return view('candidate.applications.recommendations');
    })->name('recommendations');
});

/*
|--------------------------------------------------------------------------
| 4. RECRUITER ROUTES (Phân hệ Nhà tuyển dụng)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/recruiter/
| Lưu ý: Sau này sẽ thêm Middleware `auth` và kiểm tra Role = Recruiter vào Group này
*/
Route::prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', function () {
        return view('recruiter.dashboard');
    })->name('dashboard');
    Route::get('/company-profile', function () {
        return view('recruiter.company_profile');
    })->name('company_profile');

    // Quản lý Job
    Route::get('/jobs', function () {
        return view('recruiter.jobs.index');
    })->name('jobs.index');
    Route::get('/jobs/create', function () {
        return view('recruiter.jobs.form');
    })->name('jobs.create');

    // Hệ thống ATS (Quản lý ứng viên nộp đơn)
    Route::get('/applicants', function () {
        return view('recruiter.applicants.index');
    })->name('applicants.index');
    Route::get('/applicants/detail', function () {
        return view('recruiter.applicants.show');
    })->name('applicants.show');
});

/*
|--------------------------------------------------------------------------
| 5. ADMIN ROUTES (Phân hệ Quản trị viên)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/admin/
| Lưu ý: Sau này sẽ thêm Middleware `auth` và kiểm tra Role = Admin vào Group này
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    Route::get('/jobs-moderation', function () {
        return view('admin.jobs.index');
    })->name('jobs.index');

    // Master Data
    Route::get('/master-data/skills', function () {
        return view('admin.master_data.skills');
    })->name('skills.index');
    Route::get('/master-data/languages', function () {
        return view('admin.master_data.languages');
    })->name('languages.index');

    // Logs AI
    Route::get('/logs/ai-matching', function () {
        return view('admin.logs.ai_matching');
    })->name('logs.ai_matching');
});