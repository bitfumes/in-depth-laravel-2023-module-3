<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', function (Request $request) {
    $user = User::create([
        'email'    => $request->email,
        'password' => $request->password ,
        'name'     => $request->name,
    ]);
    return $user;
});
