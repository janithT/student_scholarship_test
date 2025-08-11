<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Logs\ApplicationLogController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');


    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        // Both admin and student can view list and details
        Route::get('/scholarships', [ScholarshipController::class, 'index'])->name('scholarship.index');

        // Admin-only routes
        Route::middleware('role:Admin')->group(function () {
             Route::apiResource('scholarships', ScholarshipController::class)->except(['index']);  
        });

        // Student-only routes
        Route::middleware('role:Student')->group(function () {
            //Application routes
            Route::post('/applications', [ApplicationController::class, 'store'])->name('application.store');
            Route::post('/applications/{application}/documents', [ApplicationController::class, 'uploadDocuments'])->name('application.uploadDocuments');
            // because of below route, I'll skip the perfix group for applications
            Route::get('/my-applications', [ApplicationController::class, 'index'])->name('application.index');
            Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('application.show');

            //Application logs
            Route::get('/applications/{application}/logs', [ApplicationLogController::class, 'show']);
        });

    });
});
