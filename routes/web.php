<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\User\RepairRequestController as UserRepair;
use App\Http\Controllers\Admin\RepairRequestController as AdminRepair;

// หน้าแรก
Route::get('/', fn () => view('welcome'));

// Auth
Auth::routes([
    'register' => false, // ปิดการสมัครสมาชิก
]);

// USER SECTION
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::resource('/requests', UserRepair::class)->except(['create', 'edit']);
    Route::patch('/requests/{id}/cancel', [UserRepair::class, 'cancel'])->name('requests.cancel');
});

// ADMIN SECTION
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/requests', AdminRepair::class)->only(['index', 'update', 'store', 'destroy']);
});
