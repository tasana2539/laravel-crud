<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\User\RepairRequestController as UserRepair;
use App\Http\Controllers\Admin\RepairRequestController as AdminRepair;
use App\Http\Controllers\Technician\RepairRequestController as TechnicianRepair;
use App\Http\Controllers\ITManager\RepairRequestController as ITmanagerRepair;

// หน้าแรก
Route::get('/', fn () => view('welcome'));

// Auth
Auth::routes([
    'register' => false, // ปิดการสมัครสมาชิก
]);

// USER SECTION
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::resource('/requests', UserRepair::class)->only(['index', 'update', 'store', 'destroy']);
    Route::patch('/requests/{id}/cancel', [UserRepair::class, 'cancel'])->name('requests.cancel');
});

// ADMIN SECTION
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/requests', AdminRepair::class)->only(['index', 'update', 'store', 'destroy']);
});

// TECHNICIAN SECTION
Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function () {
    Route::resource('/requests', TechnicianRepair::class)->only(['index', 'update']);
});

// MANAGER SECTION
Route::middleware(['auth', 'role:it-manager'])->prefix('it-manager')->name('it-manager.')->group(function () {
    Route::resource('/requests', ITmanagerRepair::class)->only(['index', 'update']);
});
