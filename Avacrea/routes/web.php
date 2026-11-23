<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route User & Halaman Publik
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

Route::post('/profile/update-photo', [DashboardController::class, 'updatePhoto'])
    ->middleware('auth')
    ->name('profile.update-photo');

Route::get('/explore', [DashboardController::class, 'explore'])->name('explore');
Route::get('/creator', [DashboardController::class, 'creator'])->name('creator');

Route::post('/creator/save', [DashboardController::class, 'saveOc'])
    ->middleware('auth')
    ->name('creator.save');
// Route Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/assets', [AdminController::class, 'store'])->name('assets.store');
    Route::put('/assets/{id}', [AdminController::class, 'update'])->name('assets.update');
    Route::delete('/assets/{id}', [AdminController::class, 'destroy'])->name('assets.destroy');
});