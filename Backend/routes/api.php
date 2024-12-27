<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('user-register', [UserAuthController::class, 'register']);
Route::post('user-login', [UserAuthController::class, 'login']);

Route::get('user-logout', [UserAuthController::class, 'logout']);

// Admin-only route
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// Customer-only route
Route::middleware(['role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard']);
    Route::post('/user/profile-update', [UserController::class, 'updateProfile']);
});
