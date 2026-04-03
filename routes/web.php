<?php

use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentExamController;
use App\Http\Controllers\Student\StudentMaterialController;
use App\Http\Controllers\Student\StudentPerformanceController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\StudentResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentAuthController;



Route::get('/student/register', [StudentAuthController::class, 'showRegister']);
Route::post('/student/register', [StudentAuthController::class, 'register']);

Route::get('/student/login', [StudentAuthController::class, 'showLogin'])->name('student.login');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login');


Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
 
    Route::get('/dashboard',    [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/exam',         [StudentExamController::class,      'index'])->name('exam');
    Route::get('/exam/{id}',    [StudentExamController::class,      'start'])->name('exam.start');
    Route::post('/exam/{id}',   [StudentExamController::class,      'submit'])->name('exam.submit');
    Route::get('/results',      [StudentResultController::class,    'index'])->name('results');
    Route::get('/materials',    [StudentMaterialController::class,  'index'])->name('materials');
    Route::get('/materials/{id}/download', [StudentMaterialController::class, 'download'])->name('materials.download');
    Route::get('/performance',  [StudentPerformanceController::class, 'index'])->name('performance');
    Route::get('/profile',      [StudentProfileController::class,  'index'])->name('profile');
    Route::post('/logout',      [StudentAuthController::class,     'logout'])->name('logout');
 
});

require __DIR__.'/auth.php';
