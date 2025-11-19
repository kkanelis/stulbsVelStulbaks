<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Simple role dashboards (protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () { return view('dashboards.admin'); })->name('dashboard.admin');
    Route::get('/teacher', function () { return view('dashboards.teacher'); })->name('dashboard.teacher');
    Route::get('/student', function () { return view('dashboards.student'); })->name('dashboard.student');
});
