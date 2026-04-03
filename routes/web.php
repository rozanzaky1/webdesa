<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserSubmissionController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Frontend Routes (Public Access)
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;

// Homepage & Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-desa', [HomeController::class, 'profile'])->name('profil-desa');
Route::get('/lembaga-desa', [HomeController::class, 'institutions'])->name('lembaga-desa');

// News Routes (Public)
Route::get('/berita', [FrontendNewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [FrontendNewsController::class, 'show'])->name('berita.show');

// Services Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/layanan', [FrontendServiceController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/form', [FrontendServiceController::class, 'create'])->name('layanan.create');
    Route::post('/layanan/form', [FrontendServiceController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/riwayat', [FrontendServiceController::class, 'history'])->name('layanan.history');
    Route::get('/layanan/riwayat/{id}', [FrontendServiceController::class, 'show'])->name('layanan.show');
});

// Admin Routes (Protected by admin middleware)
Route::middleware(['admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Residents - Penduduk
Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');
Route::get('/residents/import', [ResidentController::class, 'importForm'])->name('residents.import-form');
Route::post('/residents/import', [ResidentController::class, 'import'])->name('residents.import');
Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');
Route::get('/residents/{id}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
Route::put('/residents/{id}', [ResidentController::class, 'update'])->name('residents.update');
Route::delete('/residents/{id}', [ResidentController::class, 'destroy'])->name('residents.destroy');

// Regions - Wilayah Desa
Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');

// Families - Keluarga
Route::get('/families', [FamilyController::class, 'index'])->name('families.index');
Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
Route::post('/families', [FamilyController::class, 'store'])->name('families.store');
Route::get('/families/{id}/edit', [FamilyController::class, 'edit'])->name('families.edit');
Route::put('/families/{id}', [FamilyController::class, 'update'])->name('families.update');
Route::delete('/families/{id}', [FamilyController::class, 'destroy'])->name('families.destroy');

// Hamlets - Dusun
Route::get('/hamlets', [App\Http\Controllers\HamletController::class, 'index'])->name('hamlets.index');
Route::get('/hamlets/create', [App\Http\Controllers\HamletController::class, 'create'])->name('hamlets.create');
Route::post('/hamlets', [App\Http\Controllers\HamletController::class, 'store'])->name('hamlets.store');
Route::get('/hamlets/{id}/edit', [App\Http\Controllers\HamletController::class, 'edit'])->name('hamlets.edit');
Route::put('/hamlets/{id}', [App\Http\Controllers\HamletController::class, 'update'])->name('hamlets.update');
Route::delete('/hamlets/{id}', [App\Http\Controllers\HamletController::class, 'destroy'])->name('hamlets.destroy');

// Letters - Surat
Route::get('/letters', [LetterController::class, 'index'])->name('letters.index');
Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
Route::get('/letters/{id}', [LetterController::class, 'show'])->name('letters.show');
Route::get('/letters/{id}/edit', [LetterController::class, 'edit'])->name('letters.edit');
Route::put('/letters/{id}', [LetterController::class, 'update'])->name('letters.update');
Route::get('/letters/list', [LetterController::class, 'list'])->name('letters.list');
Route::get('/letters/resident/{id}', [LetterController::class, 'getResidentData'])->name('letters.resident-data');

// Verifications - Verifikasi
Route::get('/verifications', [VerificationController::class, 'index'])->name('verifications.index');

// Village Profile - Profil Desa
Route::get('/village-profile', [App\Http\Controllers\VillageProfileController::class, 'index'])->name('village-profile.index');
Route::get('/village-profile/edit', [App\Http\Controllers\VillageProfileController::class, 'edit'])->name('village-profile.edit');
Route::put('/village-profile', [App\Http\Controllers\VillageProfileController::class, 'update'])->name('village-profile.update');

// Village Institutions - Lembaga Desa
Route::get('/village-institutions', [App\Http\Controllers\VillageInstitutionController::class, 'index'])->name('village-institutions.index');
Route::get('/village-institutions/create', [App\Http\Controllers\VillageInstitutionController::class, 'create'])->name('village-institutions.create');
Route::post('/village-institutions', [App\Http\Controllers\VillageInstitutionController::class, 'store'])->name('village-institutions.store');
Route::get('/village-institutions/{id}/edit', [App\Http\Controllers\VillageInstitutionController::class, 'edit'])->name('village-institutions.edit');
Route::put('/village-institutions/{id}', [App\Http\Controllers\VillageInstitutionController::class, 'update'])->name('village-institutions.update');
Route::delete('/village-institutions/{id}', [App\Http\Controllers\VillageInstitutionController::class, 'destroy'])->name('village-institutions.destroy');

// News - Berita Desa
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [App\Http\Controllers\NewsController::class, 'create'])->name('news.create');
Route::post('/news', [App\Http\Controllers\NewsController::class, 'store'])->name('news.store');
Route::get('/news/{id}/edit', [App\Http\Controllers\NewsController::class, 'edit'])->name('news.edit');
Route::put('/news/{id}', [App\Http\Controllers\NewsController::class, 'update'])->name('news.update');
Route::delete('/news/{id}', [App\Http\Controllers\NewsController::class, 'destroy'])->name('news.destroy');
Route::patch('/news/{id}/toggle-featured', [App\Http\Controllers\NewsController::class, 'toggleFeatured'])->name('news.toggle-featured');

// User Verification - Verifikasi User Warga
Route::get('/user-verification', [App\Http\Controllers\UserVerificationController::class, 'index'])->name('user-verification.index');
Route::post('/user-verification/{id}/approve', [App\Http\Controllers\UserVerificationController::class, 'approve'])->name('user-verification.approve');
Route::post('/user-verification/{id}/reject', [App\Http\Controllers\UserVerificationController::class, 'reject'])->name('user-verification.reject');
Route::post('/user-verification/{id}/reset-password', [App\Http\Controllers\UserVerificationController::class, 'resetPassword'])->name('user-verification.reset-password');
Route::delete('/user-verification/{id}', [App\Http\Controllers\UserVerificationController::class, 'destroy'])->name('user-verification.destroy');

// Letter Archive - Arsip Surat Keterangan
Route::get('/letter-archive', [App\Http\Controllers\LetterArchiveController::class, 'index'])->name('letter-archive.index');
Route::get('/letter-archive/create', [App\Http\Controllers\LetterArchiveController::class, 'create'])->name('letter-archive.create');
Route::post('/letter-archive', [App\Http\Controllers\LetterArchiveController::class, 'store'])->name('letter-archive.store');
Route::get('/letter-archive/{id}', [App\Http\Controllers\LetterArchiveController::class, 'show'])->name('letter-archive.show');
Route::delete('/letter-archive/{id}', [App\Http\Controllers\LetterArchiveController::class, 'destroy'])->name('letter-archive.destroy');

// Online Submission - Pengajuan Surat Online (Admin)
Route::get('/online-submission', [App\Http\Controllers\OnlineSubmissionController::class, 'index'])->name('online-submission.index');
Route::get('/online-submission/{id}', [App\Http\Controllers\OnlineSubmissionController::class, 'show'])->name('online-submission.show');
Route::patch('/online-submission/{id}/status', [App\Http\Controllers\OnlineSubmissionController::class, 'updateStatus'])->name('online-submission.update-status');
Route::post('/online-submission/{id}/update-letter', [App\Http\Controllers\OnlineSubmissionController::class, 'updateLetter'])->name('online-submission.update-letter');
Route::get('/online-submission/{id}/print', [App\Http\Controllers\OnlineSubmissionController::class, 'print'])->name('online-submission.print');
Route::delete('/online-submission/{id}', [App\Http\Controllers\OnlineSubmissionController::class, 'destroy'])->name('online-submission.destroy');
});

// User Routes (Protected by user middleware)
Route::middleware(['user'])->group(function () {
    Route::get('/user/dashboard', [UserSubmissionController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/submission/create', [UserSubmissionController::class, 'create'])->name('user.submission.create');
    Route::post('/user/submission', [UserSubmissionController::class, 'store'])->name('user.submission.store');
    Route::get('/user/submission/{id}', [UserSubmissionController::class, 'show'])->name('user.submission.show');
    Route::get('/user/submission/{id}/print', [UserSubmissionController::class, 'print'])->name('user.submission.print');
});
