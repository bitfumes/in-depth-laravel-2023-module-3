<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', function (Request $request) {
    $request->validate([
        'email'    => ['required'],
        'name'     => ['required'],
        'password' => ['required'],
    ]);

    $user = User::create([
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'name'     => $request->name,
    ]);
    return $user;
});
