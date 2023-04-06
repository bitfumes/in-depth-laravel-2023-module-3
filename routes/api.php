<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

Route::post('/user/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        $token = $user->createToken('token');
        return response(['token' => $token->plainTextToken]);
    }

    return response(['errors' => [
        'email' => ['The provided credentials are incorrect.'],
    ]]);
})->name('user.login');
