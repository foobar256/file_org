<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ApproveController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Authenticated upload routes
Route::middleware('auth')->group(function () {
    Route::get('/upload', [UploadController::class, 'create'])->name('upload.create');
    Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');

    // Approval routes (only visible to users with can_approve)
    Route::get('/approve', [ApproveController::class, 'index'])->name('approve.index');
    Route::post('/approve/{post}', [ApproveController::class, 'approve'])->name('approve.post');
});
