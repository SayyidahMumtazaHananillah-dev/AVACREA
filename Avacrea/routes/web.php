<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/explore', [DashboardController::class, 'explore'])->name('explore');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');