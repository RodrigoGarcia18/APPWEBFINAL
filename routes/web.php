<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController; 

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas del administrador
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users.view');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create'); // Ruta para crear usuario
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');

    Route::get('/admin/courses', [AdminController::class, 'viewCourses'])->name('admin.courses.view');
    Route::get('/admin/courses/create', [AdminController::class, 'createCourse'])->name('admin.courses.create'); // Ruta para crear curso
    Route::post('/admin/courses', [AdminController::class, 'storeCourse'])->name('admin.courses.store');

    Route::get('/admin/reports', [AdminController::class, 'viewReports'])->name('admin.reports.view');

    // Rutas del estudiante
    Route::group(['prefix' => 'student'], function () {
        Route::get('/profile', [StudentController::class, 'viewProfile'])->name('student.profile.view');
        Route::get('/courses', [StudentController::class, 'viewCourses'])->name('student.courses.view');
        Route::get('/activities', [StudentController::class, 'viewActivities'])->name('student.activities.view');
        Route::post('/activities/submit', [StudentController::class, 'submitAssignment'])->name('student.activities.submit'); // Para enviar tarea
    });

    // Rutas del docente
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/teacher/courses', [TeacherController::class, 'viewCourses'])->name('teacher.courses.view');
        Route::get('/teacher/activities', [TeacherController::class, 'viewActivities'])->name('teacher.activities.view');
        Route::get('/teacher/activities/create', [TeacherController::class, 'createActivity'])->name('teacher.activities.create'); // Ruta para crear actividad
        Route::post('/teacher/activities', [TeacherController::class, 'storeActivity'])->name('teacher.activities.store');
        Route::get('/teacher/grades', [TeacherController::class, 'viewGrades'])->name('teacher.grades.view');
    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.view');


});
