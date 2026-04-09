<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherNoticeController;
use App\Http\Controllers\Teacher\TeacherMaterialController;
use App\Http\Controllers\Teacher\TeacherExamController;
use App\Http\Controllers\Teacher\TeacherStudentController;



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
    
    Route::get('/exams',              [TeacherExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create',       [TeacherExamController::class, 'create'])->name('exams.create');
    Route::post('/exams',             [TeacherExamController::class, 'store'])->name('exam.store');
    Route::patch('/exams/{id}/toggle',[TeacherExamController::class, 'toggleActive'])->name('exams.toggle');
    Route::delete('/exams/{id}',      [TeacherExamController::class, 'destroy'])->name('exams.destroy');
    Route::get('/exams/{id}/submissions', [TeacherExamController::class, 'submissions'])->name('exams.submissions');  
    
    Route::get('/materials',          [TeacherMaterialController::class, 'index'])->name('materials.index');
    Route::post('/materials',         [TeacherMaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{id}',  [TeacherMaterialController::class, 'destroy'])->name('materials.destroy');

    Route::get('/notices',          [TeacherNoticeController::class, 'index'])->name('notices.index');
    Route::post('/notices',         [TeacherNoticeController::class, 'store'])->name('notices.store');
    Route::delete('/notices/{id}',  [TeacherNoticeController::class, 'destroy'])->name('notices.destroy');

    Route::get('/students',              [TeacherStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}',         [TeacherStudentController::class, 'show'])->name('students.show');
    Route::put('/students/{id}/password',[TeacherStudentController::class, 'resetPassword'])->name('students.password');

    Route::post('/logout', [App\Http\Controllers\Teacher\TeacherAuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
