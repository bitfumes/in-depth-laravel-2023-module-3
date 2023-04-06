<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', function (Request $request) {
    $request->validate([
        'email'    => ['required' , 'email'],
        'name'     => ['required'],
        'password' => ['required', 'confirmed'],
    ]);

    $user = User::create([
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'name'     => $request->name,
    ]);
    return $user;
});
