<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\User\RepairRequestController as UserRepair;
use App\Http\Controllers\Admin\RepairRequestController as AdminRepair;
use App\Http\Controllers\Technician\RepairRequestController as TechnicianRepair;
use App\Http\Controllers\ITManager\RepairRequestController as ITmanagerRepair;
use App\Http\Controllers\Repair\RepairExportController as RepairExport;
use App\Http\Controllers\Admin\ManageUsersController as ManageUser;
use App\Http\Controllers\Repair\TasksController as Task;

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
    Route::resource('/users', ManageUser::class)->only(['index', 'update', 'store', 'destroy']);
    Route::get('/users/{user}/edit', [ManageUser::class, 'edit']);
});

// TECHNICIAN SECTION
Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function () {
    Route::resource('/requests', TechnicianRepair::class)->only(['index', 'update']);
});

// MANAGER SECTION
Route::middleware(['auth', 'role:it-manager'])->prefix('it-manager')->name('it-manager.')->group(function () {
    Route::resource('/requests', ITmanagerRepair::class)->only(['index', 'update']);
});

//only user permission
Route::resource('/tasks', Task::class)
->only(['index'])
->middleware(['auth', 'role:admin,it-manager,technician']);
Route::get('/tasks/pdf/view', [Task::class, 'viewPdf'])->middleware(['auth', 'role:admin,it-manager,technician'])->name('task.pdf.view');
Route::post('/tasks/pdf/post', [Task::class, 'requestPdf'])->middleware(['auth', 'role:admin,it-manager,technician'])->name('task.pdf.request');

//global route
Route::post('/repair/pdf/single-request', [RepairExport::class, 'requestPdf'])->name('repair.pdf.single-request');
Route::get('/repair/pdf/single-view', [RepairExport::class, 'viewPdf'])->name('repair.pdf.single-view');

