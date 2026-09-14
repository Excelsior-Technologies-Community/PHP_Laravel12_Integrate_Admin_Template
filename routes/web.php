<?php

use App\Http\Controllers\AdminActivityLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [
        UserController::class,
        'dashboard'
    ]
)->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Management
|--------------------------------------------------------------------------
*/

Route::get(
    '/users',
    [
        UserController::class,
        'users'
    ]
)->name('users.index');

Route::get(
    '/users/export',
    [
        UserController::class,
        'export'
    ]
)->name('users.export');

Route::get(
    '/users/{user}',
    [
        UserController::class,
        'show'
    ]
)->name('users.show');

Route::get('/users/export', [UserController::class, 'export'])
    ->name('users.export');

/*
|--------------------------------------------------------------------------
| Admin Activity Logs
|--------------------------------------------------------------------------
*/

Route::get(
    '/activity-logs',
    [
        AdminActivityLogController::class,
        'index'
    ]
)->name('activity.logs');

Route::get(
    '/activity-logs/export',
    [
        AdminActivityLogController::class,
        'export'
    ]
)->name('activity.logs.export');

Route::delete(
    '/activity-logs/cleanup',
    [
        AdminActivityLogController::class,
        'cleanup'
    ]
)->name('activity.logs.cleanup');