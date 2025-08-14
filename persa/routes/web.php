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

Route::middleware('auth')->get('/index', [IndexController::class, 'index'])->name('index');

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

Route::middleware(['auth'])->prefix('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::middleware (['auth', 'can:coordinador'])->prefix('location')->group(function () {
    Route::get('/index', [LocationController::class, 'index'])->name('location.index');
    Route::get('/create', [LocationController::class, 'create'])->name('location.create');
    Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
    Route::post('/store', [LocationController::class, 'store'])->name('location.store');
    Route::put('/update/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/destroy/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
});

Route::middleware (['auth', 'can:coordinador'])->prefix('career')->group(function () {
    Route::get('/index', [CareerController::class, 'index'])->name('career.index');
    Route::get('/create', [CareerController::class, 'create'])->name('career.create');
    Route::get('/edit/{id}', [CareerController::class, 'edit'])->name('career.edit');
    Route::post('/store', [CareerController::class, 'store'])->name('career.store');
    Route::put('/update/{id}', [CareerController::class, 'update'])->name('career.update');
    Route::delete('/destroy/{id}', [CareerController::class, 'destroy'])->name('career.destroy');
});

Route::middleware (['auth', 'can:coordinador'])->prefix('permission_type')->group(function () {
    Route::get('/index', [PermissionTypeController::class, 'index'])->name('permission_type.index');
    Route::get('/create', [PermissionTypeController::class, 'create'])->name('permission_type.create');
    Route::get('/edit/{id}', [PermissionTypeController::class, 'edit'])->name('permission_type.edit');
    Route::post('/store', [PermissionTypeController::class, 'store'])->name('permission_type.store');
    Route::put('/update/{id}', [PermissionTypeController::class, 'update'])->name('permission_type.update');
    Route::delete('/destroy/{id}', [PermissionTypeController::class, 'destroy'])->name('permission_type.destroy');
});

Route::middleware (['auth', 'can:aprendiz'])->prefix('permission')->group(function () {
    Route::get('/index', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::put('/update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
});

Route::middleware (['auth', 'can:coordinador'])->prefix('course')->group(function () {
    Route::get('/index', [CourseController::class, 'index'])->name('course.index');
    Route::get('/create', [CourseController::class, 'create'])->name('course.create');
    Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('/store', [CourseController::class, 'store'])->name('course.store');
    Route::put('/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
});

Route::middleware (['auth', 'can:coordinador'])->prefix('users')->group(function () {
    Route::get('/index', [UsersController::class, 'index'])->name('users.index');
    Route::post('/send_email', [UsersController::class, 'send_email'])->name('users.send_email');
});

Route::middleware (['auth', 'can:coordinador-instructor'])->prefix('reports')->group(function () {
    Route::get('/index', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/export_permissions_by_apprentice', [ReportsController::class, 'export_permissions_by_apprentice'])->name('reports.permission_apprentice');
    Route::post('/export_permissions_by_date_range', [ReportsController::class, 'export_permissions_by_date_range'])->name('reports.permission_date');
    Route::post('/export_permissions_by_course', [ReportsController::class, 'export_permissions_by_course'])->name('reports.permissions_course');

});



