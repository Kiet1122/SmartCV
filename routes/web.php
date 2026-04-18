<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Candidate\DashboardController;
use App\Http\Controllers\Candidate\ProfileController;
use App\Http\Controllers\Candidate\SavedJobController;
use App\Http\Controllers\Candidate\CvController;
use App\Http\Controllers\Candidate\AiReviewController;
use App\Http\Controllers\Candidate\ApplicationController;
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
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::get('/google/redirect', [GoogleController::class, 'redirectToGoogle'])
        ->name('auth.google.redirect');

    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])
        ->name('auth.google.callback');
});


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});


Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


Route::prefix('password')->group(function () {
    Route::get('/forgot', function () {
        return view('auth.passwords.email');
    })->name('password.request');

    Route::post('/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // Reset mật khẩu
    Route::get('/reset/{token}', function ($token) {
        return view('auth.passwords.reset', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| 3. CANDIDATE ROUTES (Phân hệ Ứng viên)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/candidate/
| Lưu ý: Sau này sẽ thêm Middleware `auth` và kiểm tra Role = Candidate vào Group này
*/

Route::prefix('candidate')->name('candidate.')->middleware('auth')->group(function () {

    //
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update_avatar');

    //
    Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved_jobs');
    Route::post('/saved-jobs/{job}/toggle', [SavedJobController::class, 'toggle'])->name('saved_jobs.toggle');

    //
    Route::prefix('cv')->name('cv.')->group(function () {
        Route::get('/', [CvController::class, 'index'])->name('index');
        Route::post('/upload', [CvController::class, 'store'])->name('store');
        Route::post('/{id}/default', [CvController::class, 'setDefault'])->name('set_default');
        Route::delete('/{id}', [CvController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/update-name', [CvController::class, 'updateName'])->name('update_name');
        Route::get('/{id}/review', [CvController::class, 'reviewParsedData'])->name('review');
        Route::put('/{id}/parsed-data', [CvController::class, 'updateParsedData'])->name('update_parsed');
        Route::get('/{id}', [CvController::class, 'show'])->name('show');
        Route::get('/{id}/download', [CvController::class, 'downloadPdf'])->name('download');
        Route::post('/generate-and-save', [CvController::class, 'generateAndSaveCv'])->name('generate_and_save');
    });
    Route::prefix('ai-review')->name('ai_review.')->group(function () {
        Route::get('/', [AiReviewController::class, 'index'])->name('index');
        Route::post('/process', [AiReviewController::class, 'process'])->name('process');
    });
    Route::prefix('applications')->name('applications.')->group(function () {

        Route::get('/', [ApplicationController::class, 'index'])->name('index');

        Route::get('/recommendations', [ApplicationController::class, 'recommendations'])->name('recommendations');
    });
});

Route::prefix('candidate')->name('candidate.')->group(function () {


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