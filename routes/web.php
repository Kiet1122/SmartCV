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

use App\Http\Controllers\Recruiter\RecruiterDashboardController;
use App\Http\Controllers\Recruiter\CompanyProfileController;
use App\Http\Controllers\Recruiter\JobPostController;
use App\Http\Controllers\Recruiter\ApplicantController;
use App\Http\Controllers\Recruiter\ReportController;

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\candidate\JobsController;


/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Khách vãng lai ai cũng xem được)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/public/
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('public')->name('public.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');






    Route::get('/about', [HomeController::class, 'about'])->name('about');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');


});



Route::prefix('candidate')->name('candidate.')->group(function () {

    // Companies
    Route::get('/companies', [HomeController::class, 'companies'])->name('companies');
    Route::get('/companies/{company}', [HomeController::class, 'companyShow'])->name('companies.show');

    // Jobs
    Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');

    // Apply job
    Route::post('/jobs/{job}/apply', [JobsController::class, 'apply'])->name('jobs.apply');
});
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

// ================= CANDIDATE =================
Route::middleware(['auth', 'role:candidate'])
    ->prefix('candidate')
    ->name('candidate.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update_avatar');

        Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved_jobs');
        Route::post('/saved-jobs/{job}/toggle', [SavedJobController::class, 'toggle'])->name('saved_jobs.toggle');

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
/*
|--------------------------------------------------------------------------
| 4. RECRUITER ROUTES (Phân hệ Nhà tuyển dụng)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/recruiter/
| Lưu ý: Sau này sẽ thêm Middleware `auth` và kiểm tra Role = Recruiter vào Group này
*/

// Recruiter routes group
Route::middleware(['auth', 'role:recruiter'])
    ->prefix('recruiter')
    ->name('recruiter.')
    ->group(function () {
        Route::get('/dashboard', [RecruiterDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [CompanyProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [CompanyProfileController::class, 'update'])->name('update');

        Route::resource('jobs', JobPostController::class);
        Route::patch('/jobs/{job}/close', [JobPostController::class, 'close'])->name('jobs.close');

        // Trong group 'recruiter'
        Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants.index');
        Route::get('/applicants/job/{job}', [ApplicantController::class, 'listByJob'])->name('applicants.listByJob');
        Route::get('/applicants/{applicant}', [ApplicantController::class, 'show'])->name('applicants.show');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });


/*
|--------------------------------------------------------------------------
| 5. ADMIN ROUTES (Phân hệ Quản trị viên)
|--------------------------------------------------------------------------
| Trỏ vào thư mục: resources/views/admin/
| Lưu ý: Sau này sẽ thêm Middleware `auth` và kiểm tra Role = Admin vào Group này
*/
