<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionTypeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::prefix('location')->group(function(){
    Route::get('/index', [LocationController::class, 'index'])->name('location.index');
    Route::get('/create', [LocationController::class, 'create'])->name('location.create');
    Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
    Route::post('/store', [LocationController::class, 'store'])->name('location.store');
    Route::put('/update/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/destroy/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
});

Route::prefix('career')->group(function(){
    Route::get('/index', [CareerController::class, 'index'])->name('career.index');
    Route::get('/create', [CareerController::class, 'create'])->name('career.create');
    Route::get('/edit/{id}', [CareerController::class, 'edit'])->name('career.edit');
    Route::post('/store', [CareerController::class, 'store'])->name('career.store');
    Route::put('/update/{id}', [CareerController::class, 'update'])->name('career.update');
    Route::delete('/destroy/{id}', [CareerController::class, 'destroy'])->name('career.destroy');
});


Route::prefix('permission_type')->group(function(){
    Route::get('/index',[PermissionTypeController::class, 'index'])->name('permission_type.index');
    Route::get('/create',[PermissionTypeController::class, 'create'])->name('permission_type.create');
    Route::get('/edit{id}',[PermissionTypeController::class, 'edit'])->name('permission_type.edit');
    Route::post('/store',[PermissionTypeController::class, 'store'])->name('permission_type.store');
    Route::put('/update/{id}',[PermissionTypeController::class, 'update'])->name('permission_type.update');
    Route::delete('/destroy/{id}',[PermissionTypeController::class, 'destroy'])->name('permission_type.destroy');
});

Route::prefix('permission')->group(function(){
    Route::get('/index',[PermissionController::class, 'index'])->name('permission.index');
    Route::get('/create',[PermissionController::class, 'create'])->name('permission.create');
    Route::get('/edit{id}',[PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/store',[PermissionController::class, 'store'])->name('permission.store');
    Route::put('/update/{id}',[PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/destroy/{id}',[PermissionController::class, 'destroy'])->name('permission.destroy');
});


Route::prefix('course')->group(function(){
    Route::get('/index',[CourseController::class, 'index'])->name('course.index');
    Route::get('/create',[CourseController::class, 'create'])->name('course.create');
    Route::get('/edit{id}',[CourseController::class, 'edit'])->name('course.edit');
    Route::post('/store',[CourseController::class, 'store'])->name('course.store');
    Route::put('/update/{id}',[CourseController::class, 'update'])->name('course.update');
    Route::delete('/destroy/{id}',[CourseController::class, 'destroy'])->name('course.destroy');
});


Route::prefix('pemission')->group(function(){
    Route::get('/index',[PermissionController::class, 'index'])->name('permission.index');
    Route::get('/create',[PermissionController::class, 'create'])->name('permission.create');
    Route::get('/edit{id}',[PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/store',[PermissionController::class, 'store'])->name('permission.store');
    Route::put('/update/{id}',[PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/destroy/{id}',[PermissionController::class, 'destroy'])->name('permission.destroy');
});
Route::prefix('users')->group(function(){
    Route::get('/index', [UsersController::class, 'index'])->name('users.index');
    Route::post('/send_email', [UsersController::class, 'send_email'])->name('users.send_email');
});