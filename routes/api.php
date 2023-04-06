<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.login');
