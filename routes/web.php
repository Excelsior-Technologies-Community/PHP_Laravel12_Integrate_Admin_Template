<?php

use App\Http\Controllers\AdminActivityLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [
    UserController::class,
    'dashboard'
])->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Management
|--------------------------------------------------------------------------
*/

Route::get('/users', [
    UserController::class,
    'users'
])->name('users.index');

Route::get('/users/{user}', [
    UserController::class,
    'show'
])->name('users.show');

/*
|--------------------------------------------------------------------------
| Admin Activity Logs
|--------------------------------------------------------------------------
*/

Route::get('/activity-logs', [
    AdminActivityLogController::class,
    'index'
])->name('activity.logs');