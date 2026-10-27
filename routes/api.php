<?php

use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/config', [ConfigController::class, 'index']);
    Route::get('/domains', [ConfigController::class, 'domains']);

    Route::get('/pages/{slug}', [PageController::class, 'show']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{slug}', [ProjectController::class, 'show']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);

    Route::get('/testimonials', [TestimonialController::class, 'index']);

    Route::post('/inquiries', [InquiryController::class, 'store']);
});
