<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// HALAMAN PENGUNJUNG (BELUM LOGIN)
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register']);

});


// HALAMAN YANG MEMERLUKAN LOGIN
Route::middleware(['auth', 'role:admin,user'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])
        ->name('profile');

    // Explore
    Route::get('/explore', [DashboardController::class, 'explore'])
        ->name('explore');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
