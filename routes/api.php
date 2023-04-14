<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailListController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/email-list', [EmailListController::class, 'store'])->name('email-lists.store');
});
