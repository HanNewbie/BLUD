<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AccountUserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\Auth\GoogleController;

// User routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event', [HomeController::class, 'event'])->name('event');
Route::get('/booking/{slug}', [HomeController::class, 'booking'])->name('booking');
Route::get('/booking/{slug}/{bulan}', [HomeController::class, 'bookingDetail'])->name('booking.detail');
Route::get('/wisata',[HomeController::class, 'content'])->name('wisata');
Route::get('/wisata/{slug}',[HomeController::class, 'contentDetail'])->name('wisata.detail');
Route::get('/fasilitas/{location}',[HomeController::class, 'facility'])->name('fasilitas');
Route::get('/penyewaan',[HomeController::class, 'createSubmission'])->name('submission');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');    
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.post');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/history', [HomeController::class, 'history'])->name('user.history');
    Route::get('/profil', [HomeController::class, 'profile'])->name('profile');
    Route::post('/penyewaan',[HomeController::class, 'storeSubmission'])->name('user.submission.store');
});



// Admin routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::post('/logout', function () {Auth::logout();return redirect('/admin/login');})->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('account', AccountController::class);
    Route::resource('user', AccountUserController::class);
    Route::resource('event', EventController::class);
    Route::resource('news', NewsController::class);

    Route::resource('content', ContentController::class);
    Route::post('/features', [FeatureController::class, 'store'])->name('features.store');
    Route::post('/feature/edit', [FeatureController::class, 'update'])->name('feature.update');
    Route::get('/content/{id}/facilities', [FeatureController::class, 'index'])->name('content.facilities');

    Route::get('submission', [SubmissionController::class, 'index'])->name('submission.index');
    Route::get('submission/approved', [SubmissionController::class, 'approved'])->name('submission.approved.list');
    Route::get('submission/rejected', [SubmissionController::class, 'rejected'])->name('submission.rejected.list');
    // PUT untuk menyetujui/menolak 
    Route::put('submission/{id}/approve', [SubmissionController::class, 'approve'])->name('submission.approved');
    Route::put('submission/{id}/reject', [SubmissionController::class, 'reject'])->name('submission.rejected');
});

