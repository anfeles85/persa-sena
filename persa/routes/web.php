<?php

use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionTypeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/register', [ApprenticeController::class, 'create'])->name('auth.register');
    Route::post('/register', [ApprenticeController::class, 'store'])->name('auth.store');

    Route::get('/changePassword', [ChangePasswordController::class, 'index'])->name('auth.changePassword');
    Route::post('/changePassword', [ChangePasswordController::class, 'changePassword'])->name('auth.changePassword');

    Route::get('/profile', [ApprenticeController::class, 'edit'])->name('user.profile');
    Route::put('/profile', [ApprenticeController::class, 'update'])->name('user.profile.update');
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');


});

Route::middleware('auth')->group(function () {

    Route::get('/index', [IndexController::class, 'index'])->name('index');
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Coordinador - Sedes
    Route::middleware('can:coordinador')->prefix('location')->group(function () {
        Route::resource('/', LocationController::class)->parameters(['' => 'id'])->names('location');
    });

    // Coordinador - Carreras
    Route::middleware('can:coordinador')->prefix('career')->group(function () {
        Route::resource('/', CareerController::class)->parameters(['' => 'id'])->names('career');
    });

    // Coordinador - Tipos de Permiso
    Route::middleware('can:coordinador')->prefix('permission_type')->group(function () {
        Route::resource('/', PermissionTypeController::class)->parameters(['' => 'id'])->names('permission_type');
    });

    // Aprendiz - Permisos
    Route::middleware('can:aprendiz')->prefix('permission')->group(function () {
        Route::resource('/', PermissionController::class)->parameters(['' => 'id'])->names('permission');
    });

    // Coordinador - Cursos
    Route::middleware('can:coordinador')->prefix('course')->group(function () {
        Route::resource('/', CourseController::class)->parameters(['' => 'id'])->names('course');
    });

    // Coordinador - Usuarios
    Route::middleware('can:coordinador')->prefix('users')->group(function () {
        Route::get('/index', [UsersController::class, 'index'])->name('users.index');
        Route::post('/send_email', [UsersController::class, 'send_email'])->name('users.send_email');
    });

    // Coordinador / Instructor - Reportes
    Route::middleware('can:coordinador-instructor')->prefix('reports')->group(function () {
        Route::get('/index', [ReportsController::class, 'index'])->name('reports.index');
        Route::post('/export_permissions_by_apprentice', [ReportsController::class, 'export_permissions_by_apprentice'])->name('reports.permission_apprentice');
        Route::post('/export_permissions_by_date_range', [ReportsController::class, 'export_permissions_by_date_range'])->name('reports.permission_date');
        Route::post('/export_permissions_by_course', [ReportsController::class, 'export_permissions_by_course'])->name('reports.permissions_course');
    });

});
