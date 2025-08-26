<?php

use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionTypeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

//prueba
Route::get('/help', function () {return view('help');})->name('help.help');
// RUTA PÚBLICA
Route::get('/', [AuthController::class, 'index'])->name('auth.index');

// RUTAS DE AUTENTICACIÓN
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/register', [ApprenticeController::class, 'create'])->name('auth.register');
    Route::post('/register', [ApprenticeController::class, 'store'])->name('auth.store');

    Route::get('/changePassword', [ChangePasswordController::class, 'index'])->name('auth.changePassword');
    Route::post('/changePassword', [ChangePasswordController::class, 'changePassword'])->name('auth.changePassword');

    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('auth.forget-password');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('auth.forget-password-link');
    
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    
    Route::get('/profile', [ApprenticeController::class, 'edit'])->name('user.profile');
    Route::put('/profile', [ApprenticeController::class, 'update'])->name('user.profile.update');
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// RUTAS PROTEGIDAS POR AUTENTICACIÓN
Route::middleware('auth')->group(function () {

    Route::get('/index', [IndexController::class, 'index'])->name('index');

    //Coordinador - Gestión de usuarios
    Route::middleware('can:coordinador')->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/apprentices', [UserController::class, 'indexApprentice'])->name('user.apprentices');
        Route::get('/instructors', [UserController::class, 'indexInstructors'])->name('user.instructors');
        Route::get('/guard', [UserController::class, 'indexGuard'])->name('user.guard');

        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::post('/send_email', [UserController::class, 'send_email'])->name('users.send_email');
    });

    //Coordinador - Sedes
    Route::middleware('can:coordinador')->prefix('location')->group(function () {
        Route::resource('/', LocationController::class)->parameters(['' => 'id'])->names('location');
    });

    //Coordinador - Carreras
    Route::middleware('can:coordinador')->prefix('career')->group(function () {
        Route::resource('/', CareerController::class)->parameters(['' => 'id'])->names('career');
    });

    //Coordinador - Tipos de Permiso
    Route::middleware('can:coordinador')->prefix('permission_type')->group(function () {
        Route::resource('/', PermissionTypeController::class)->parameters(['' => 'id'])->names('permission_type');
    });

    //Coordinador - Cursos
    Route::middleware('can:coordinador')->prefix('course')->group(function () {
        Route::resource('/', CourseController::class)->parameters(['' => 'id'])->names('course');
    });

    // Permisos
    Route::patch('/permission/{id}/approve', [PermissionController::class, 'approve'])->name('permission.approve');
    Route::patch('/permission/{id}/cancel', [PermissionController::class, 'cancel'])->name('permission.cancel');
    Route::prefix('permission')->group(function () {
        Route::resource('/', PermissionController::class)->parameters(['' => 'id'])->names('permission');
    });

    //Coordinador / Instructor - Reportes
    Route::middleware('can:coordinador-instructor')->prefix('reports')->group(function () {
        Route::get('/index', [ReportsController::class, 'index'])->name('reports.index');
        Route::post('/export_permissions_by_apprentice', [ReportsController::class, 'export_permissions_by_apprentice'])->name('reports.permission_apprentice');
        Route::post('/export_permissions_by_date_range', [ReportsController::class, 'export_permissions_by_date_range'])->name('reports.permission_date');
        Route::post('/export_permissions_by_course', [ReportsController::class, 'export_permissions_by_course'])->name('reports.permissions_course');
    });

    //Prueba
    Route::prefix('apprentice')->group(function () {
        Route::get('/', [ApprenticeController::class, 'index'])->name('apprentice.index');
        Route::patch('/{id}/toggle-status', [ApprenticeController::class, 'toggleStatus'])->name('apprentice.toggleStatus');
        Route::get('/{id}/profile', [ApprenticeController::class, 'showProfile'])->name('apprentice.profile');
        Route::put('/{id}/profile', [ApprenticeController::class, 'updateProfile'])->name('apprentice.profile.update');
    });

});
