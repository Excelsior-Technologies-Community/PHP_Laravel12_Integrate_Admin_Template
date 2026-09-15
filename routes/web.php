<?php

use App\Http\Controllers\AdminActivityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| 1. Admin Dashboard Overview
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| 2. User Management & Complete CRUD
|--------------------------------------------------------------------------
*/
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'users'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/trash', [UserController::class, 'trash'])->name('trash');
    Route::get('/export', [UserController::class, 'export'])->name('export');
    Route::post('/bulk', [UserController::class, 'bulkAction'])->name('bulk');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/{id}/restore', [UserController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
});

/*
|--------------------------------------------------------------------------
| 3. Administrator Profile & Password
|--------------------------------------------------------------------------
*/
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
});

/*
|--------------------------------------------------------------------------
| 4. System Settings Hub & Backups
|--------------------------------------------------------------------------
*/
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::put('/general', [SettingController::class, 'updateGeneral'])->name('general');
    Route::post('/maintenance', [SettingController::class, 'toggleMaintenance'])->name('maintenance');
    Route::post('/email/test', [SettingController::class, 'testEmail'])->name('email.test');
    Route::post('/backup/create', [SettingController::class, 'createBackup'])->name('backup.create');
    Route::get('/backup/{id}/download', [SettingController::class, 'downloadBackup'])->name('backup.download');
    Route::delete('/backup/{id}', [SettingController::class, 'deleteBackup'])->name('backup.delete');
});

/*
|--------------------------------------------------------------------------
| 5. Admin Activity Logs
|--------------------------------------------------------------------------
*/
Route::prefix('activity-logs')->name('activity.logs')->group(function () {
    Route::get('/', [AdminActivityLogController::class, 'index']);
    Route::get('/export', [AdminActivityLogController::class, 'export'])->name('.export');
    Route::delete('/cleanup', [AdminActivityLogController::class, 'cleanup'])->name('.cleanup');
});