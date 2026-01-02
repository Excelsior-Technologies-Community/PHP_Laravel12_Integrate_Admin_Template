<?php

use App\Http\Controllers\UserController;

// Dashboard page route
Route::get('/dashboard', [UserController::class, 'dashboard']);

// Users listing route
Route::get('/users', [UserController::class, 'users']);

