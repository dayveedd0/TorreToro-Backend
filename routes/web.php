<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Named fallback for Laravel's default auth redirect
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Authentication
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Authenticated Admin Routes
    Route::middleware('auth')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/switch-domain', [DashboardController::class, 'switchDomain'])->name('switch_domain');
        Route::get('/switch-domain/{code}', [DashboardController::class, 'switchDomainGet'])->name('switch_domain_get');

        // Visual Homepage Content & Sections Editor
        Route::get('/home-editor', [HomePageController::class, 'edit'])->name('home_editor.edit');
        Route::put('/home-editor', [HomePageController::class, 'update'])->name('home_editor.update');

        Route::resource('services', ServiceController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('posts', PostController::class);
        Route::resource('pages', PageController::class)->only(['index', 'edit', 'update']);
        Route::resource('testimonials', TestimonialController::class);

        // Media & Asset Library
        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::get('/media/api', [MediaController::class, 'api'])->name('media.api');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media', [MediaController::class, 'destroy'])->name('media.destroy');

        // User & Role Management
        Route::resource('users', UserController::class);

        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
        Route::post('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
        Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // System Maintenance Helpers
        Route::post('/system/storage-link', function () {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            return back()->with('success', 'Storage link executed: ' . trim(\Illuminate\Support\Facades\Artisan::output()));
        })->name('system.storage_link');

        Route::post('/system/clear-cache', function () {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            return back()->with('success', 'All system caches cleared successfully!');
        })->name('system.clear_cache');
    });
});
