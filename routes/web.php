<?php

use Illuminate\Support\Facades\Route;



Route::prefix('student')->group(function () {
    Route::get('/register', [App\Http\Controllers\Student\StudentAuthController::class, 'showRegister']);
    Route::post('/register', [App\Http\Controllers\Student\StudentAuthController::class, 'register']);

    Route::get('/login', [App\Http\Controllers\Student\StudentAuthController::class, 'showLogin'])->name('student.login');
    Route::post('/login', [App\Http\Controllers\Student\StudentAuthController::class, 'login'])->name('student.login');
});

Route::prefix('teacher')->group(function () {
    Route::get('/sign-up', [App\Http\Controllers\Teacher\TeacherAuthController::class, 'showRegister']);
    Route::post('/sign-up', [App\Http\Controllers\Teacher\TeacherAuthController::class, 'register']);

    Route::get('/sign-in', [App\Http\Controllers\Teacher\TeacherAuthController::class, 'showLogin'])->name('teacher.login');
    Route::post('/sign-in', [App\Http\Controllers\Teacher\TeacherAuthController::class, 'login'])->name('teacher.login');
});

Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
 
    Route::get('/dashboard',    [App\Http\Controllers\Student\StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/exam',         [App\Http\Controllers\Student\StudentExamController::class,      'index'])->name('exam');
    Route::get('/exam/{id}',    [App\Http\Controllers\Student\StudentExamController::class,      'start'])->name('exam.start');
    Route::post('/exam/{id}',   [App\Http\Controllers\Student\StudentExamController::class,      'submit'])->name('exam.submit');
    Route::get('/results',      [App\Http\Controllers\Student\StudentResultController::class,    'index'])->name('results');
    Route::get('/materials',    [App\Http\Controllers\Student\StudentMaterialController::class,  'index'])->name('materials');
    Route::get('/materials/{id}/download', [App\Http\Controllers\Student\StudentMaterialController::class, 'download'])->name('materials.download');
    Route::get('/performance',  [App\Http\Controllers\Student\StudentPerformanceController::class, 'index'])->name('performance');
    Route::get('/profile',      [App\Http\Controllers\Student\StudentProfileController::class,  'index'])->name('profile');
    Route::post('/logout',      [App\Http\Controllers\Student\StudentAuthController::class,     'logout'])->name('logout');
 
});

Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\TeacherDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/exams',              [App\Http\Controllers\Teacher\TeacherExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create',       [App\Http\Controllers\Teacher\TeacherExamController::class, 'create'])->name('exams.create');
    Route::post('/exams',             [App\Http\Controllers\Teacher\TeacherExamController::class, 'store'])->name('exam.store');
    Route::patch('/exams/{id}/toggle',[App\Http\Controllers\Teacher\TeacherExamController::class, 'toggleActive'])->name('exams.toggle');
    Route::delete('/exams/{id}',      [App\Http\Controllers\Teacher\TeacherExamController::class, 'destroy'])->name('exams.destroy');
    Route::get('/exams/{id}/submissions', [App\Http\Controllers\Teacher\TeacherExamController::class, 'submissions'])->name('exams.submissions');  
    
    Route::post('/logout', [App\Http\Controllers\Teacher\TeacherAuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
