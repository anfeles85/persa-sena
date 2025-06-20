<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionTypeController;
use App\Http\Controllers\RolesController;
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
    return view('welcome');
});


Route::prefix('location')->group(function(){
    Route::get('/index', [LocationController::class, 'index'])->name('location.index');
    Route::get('/create', [LocationController::class, 'create'])->name('location.create');
    Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
    Route::post('/store', [LocationController::class, 'store'])->name('location.store');
    Route::put('/update{id}', [LocationController::class, 'update'])->name('location.update');
    Route::get('/destroy{id}', [LocationController::class, 'destroy'])->name('location.destroy');
});

Route::prefix('career')->group(function(){
    Route::get('/index', [CareerController::class, 'index'])->name('career.index');
    Route::get('/create', [CareerController::class, 'create'])->name('career.create');
    Route::get('/edit/{id}', [CareerController::class, 'edit'])->name('career.edit');
    Route::post('/store', [CareerController::class, 'store'])->name('career.store');
    Route::put('/update/{id}', [CareerController::class, 'update'])->name('career.update');
    Route::get('/destroy/{id}', [CareerController::class, 'destroy'])->name('career.destroy');
});


Route::prefix('permission_type')->group(function(){
    Route::get('/index',[PermissionTypeController::class, 'index'])->name('permission_type.index');
    Route::get('/create',[PermissionTypeController::class, 'create'])->name('permission_type.create');
    Route::get('/edit{id}',[PermissionTypeController::class, 'edit'])->name('permission_type.edit');
    Route::post('/store',[PermissionTypeController::class, 'store'])->name('permission_type.store');
    Route::put('/update{id}',[PermissionTypeController::class, 'update'])->name('permission_type.update');
    Route::get('/destroy{id}',[PermissionTypeController::class, 'destroy'])->name('permission_type.destroy');
});

Route::prefix('roles')->group(function(){
    Route::get('/index', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/create', [RolesController::class, 'create'])->name('roles.create');
    Route::get('/edit/{id}', [RolesController::class, 'edit'])->name('roles.edit');
    Route::post('/store', [RolesController::class, 'store'])->name('roles.store');
    Route::put('/update/{id}', [RolesController::class, 'update'])->name('roles.update');
    Route::get('/destroy/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
});
