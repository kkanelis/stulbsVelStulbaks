<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;

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
    
    // Teacher only routes
    Route::middleware('teacher')->group(function () {
        Route::get('/teacher', [TeacherController::class, 'dashboard'])->name('dashboard.teacher');
        Route::post('/teacher/subject', [TeacherController::class, 'setSubject'])->name('teacher.setSubject');
        Route::post('/teacher/subject/regenerate', [TeacherController::class, 'regenerateCode'])->name('teacher.regenerateCode');
        Route::post('/teacher/assignment', [TeacherController::class, 'storeAssignment'])->name('teacher.storeAssignment');
        Route::put('/teacher/assignment/{assignment}', [TeacherController::class, 'updateAssignment'])->name('teacher.updateAssignment');
        Route::delete('/teacher/assignment/{assignment}', [TeacherController::class, 'destroyAssignment'])->name('teacher.destroyAssignment');
        Route::post('/teacher/grade/{assignment}', [TeacherController::class, 'gradeAssignment'])->name('teacher.gradeAssignment');
    });
    
    // Student only routes
    Route::middleware('student')->group(function () {
        Route::get('/student', function () { return view('dashboards.student'); })->name('dashboard.student');
        Route::post('/student/join', [\App\Http\Controllers\EnrollmentController::class, 'joinCourse'])->name('student.join');
        Route::get('/student/course/{subject}', [\App\Http\Controllers\EnrollmentController::class, 'showCourse'])->name('student.course.show');
    });

    // Assignment detail and upload (accessible by both teachers and students)
    Route::get('/assignment/{assignment}', [\App\Http\Controllers\AssignmentController::class, 'show'])->name('assignment.show');
    Route::post('/assignment/{assignment}/upload', [\App\Http\Controllers\AssignmentController::class, 'upload'])->name('assignment.upload');
    Route::get('/file/{file}/download', [\App\Http\Controllers\AssignmentController::class, 'download'])->name('file.download');
});

