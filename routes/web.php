<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ActivitySubmissionController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UpdateUserController;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

//redireccion a login
Route::get('/', function () {
    if (session('user')) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/meet/{courseId}', [CourseController::class, 'startMeeting'])->name('meet.start');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('courses', CourseController::class);
});

// Rutas protegidas por autenticación de middleware-auth
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ADMIN
    //Rutas de usuarios
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users.index');
    Route::get('/admin/users', [AdminController::class, 'viewUsers'])->name('admin.users.view');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [UpdateUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UpdateUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    //Rutas de cursos

    Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/admin/courses', [CourseController::class, 'viewCourses'])->name('admin.courses.view');
    Route::get('/admin/courses/create', [CourseController::class, 'createCourse'])->name('admin.courses.create');
    Route::post('/admin/courses', [CourseController::class, 'storeCourse'])->name('admin.courses.store');
    Route::get('/admin/courses/{id}/edit', [CourseController::class, 'editCourse'])->name('admin.courses.edit');
    Route::put('/admin/courses/{id}', [CourseController::class, 'updateCourse'])->name('admin.courses.update');
    Route::delete('/admin/courses/{id}', [CourseController::class, 'destroyCourse'])->name('admin.courses.destroy');
    Route::delete('/admin/courses/{id}', [AdminController::class, 'destroyCourse'])->name('admin.courses.destroy');

    Route::get('/admin/matriculados', [CourseController::class, 'viewStudents'])->name('admin.courses.matriculados');

    Route::get('/admin/reports', [AdminController::class, 'viewReports'])->name('admin.reports.view');
    Route::get('/reports/courses/export', [ReportController::class, 'exportCourses'])->name('admin.reports.exportCourses');
    Route::get('/reports/users/export', [ReportController::class, 'exportUsers'])->name('admin.reports.exportUsers');
    Route::get('/reports/teachers/export', [ReportController::class, 'exportTeachers'])->name('admin.reports.exportTeachers');
    Route::get('/reports/students/export', [ReportController::class, 'exportStudents'])->name('admin.reports.exportStudents');

    // STUDENTS
    // Rutas del estudiante
    Route::group(['prefix' => 'student'], function () {
        Route::get('/profile', [StudentController::class, 'viewProfile'])->name('student.profile.view');
        Route::get('/courses', [StudentController::class, 'viewCourses'])->name('student.courses.view');
        Route::get('/courses/{id}', [StudentController::class, 'showCourseDetails'])->name('student.courses.details');
        Route::get('/activities', [StudentController::class, 'viewActivities'])->name('student.activities.view');
        Route::get('activities/{activityId}/submit', [ActivitySubmissionController::class, 'create'])->name('activity.submit');
        Route::post('activities/{activityId}/submit', [ActivitySubmissionController::class, 'store'])->name('activity.store');
        Route::post('/activities/submit', [StudentController::class, 'submitAssignment'])->name('student.activities.submit'); // Para enviar tarea
    });

    // Rutas del docente
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/courses', [TeacherController::class, 'viewCourses'])->name('teacher.courses.view');
        Route::get('/courses/{id}', [TeacherController::class, 'showCourseDetails'])->name('teacher.courses.details'); // Detalles del curso
        Route::post('/courses/{id}/updateSessionLink', [TeacherController::class, 'updateSessionLink'])->name('teacher.courses.updateSessionLink'); // Ruta para actualizar el enlace de sesión
        Route::post('/courses/{id}/updateMaterialLink', [TeacherController::class, 'updateMaterialLink'])->name('teacher.courses.updateMaterialLink');
        Route::get('/activities', [TeacherController::class, 'viewActivities'])->name('teacher.activities.view');
        Route::get('/activities/create', [TeacherController::class, 'createActivity'])->name('teacher.activities.create'); // Ruta para crear actividad
        Route::post('/activities', [TeacherController::class, 'storeActivity'])->name('teacher.activities.store');

        // Ruta para ver las notas
        Route::get('/grades', [TeacherController::class, 'viewGrades'])->name('teacher.grades.view');
        Route::post('/grades/store', [TeacherController::class, 'storeGrade'])->name('teacher.notas.store');
        Route::get('/grades/{activity}/submissions', [TeacherController::class, 'viewSubmissions'])->name('teacher.grades.submissions');
        Route::post('/grades/notas/update', [TeacherController::class, 'updateGrades'])->name('teacher.notas.update');
        // Ruta para la asistencia
        Route::get('/attendance', [AttendanceController::class, 'view'])->name('teacher.attendance.view');
        Route::post('/attendance/mark', [AttendanceController::class, 'mark'])->name('teacher.attendance.mark'); // Ruta para marcar la asistencia
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('teacher.attendance.create'); // Nueva ruta para crear asistencia
        Route::get('/attendance/create/{courseId}', [AttendanceController::class, 'create'])->name('teacher.attendance.create');
        Route::get('/teacher/attendance/details/{courseId}', [AttendanceController::class, 'viewDetails'])->name('teacher.attendance.details');

        // Ruta para la creacion de actividades
        Route::get('/activities', [ActivityController::class, 'viewActivities'])->name('teacher.activities.view'); // Ver todas las actividades
        Route::get('/activities/create', [ActivityController::class, 'createActivity'])->name('teacher.activities.create'); // Crear nueva actividad
        Route::post('/activities', [ActivityController::class, 'storeActivity'])->name('teacher.activities.store'); // Almacenar nueva actividad
        Route::get('/activities/{id}', [ActivityController::class, 'showActivity'])->name('teacher.activities.show'); // Mostrar detalles de la actividad
        Route::get('/activities/{id}/edit', [ActivityController::class, 'editActivity'])->name('teacher.activities.edit'); // Editar actividad
        Route::put('/teacher/activities/{id}', [ActivityController::class, 'updateActivity'])->name('teacher.activities.update');
        Route::delete('/activities/{id}', [ActivityController::class, 'destroyActivity'])->name('teacher.activities.destroy'); // Eliminar actividad

        //Rutas para subir las actividades


        //Rutas para ver las actividades
        Route::get('submissions', [ActivitySubmissionController::class, 'index'])->name('submissions.index');

        Route::post('/attendance', [AttendanceController::class, 'store'])->name('teacher.attendance.store'); // Ruta para guardar asistencia
    });


//MUGUERZA NO MUEVAS NADA, COMO BIEN DICE EL DICHO: SI FUNCIONA NO LO TOQUES XD


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.view');
});
