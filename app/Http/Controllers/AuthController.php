<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'name'     => $request->name,
        ]);
        $user->notify(new VerifyEmailNotification());
        return $user;
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->whereNotNull('email_verified_at')
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token');
            return response(['token' => $token->plainTextToken]);
        }

        return response(['errors' => [
            'email' => ['The provided credentials are incorrect.'],
        ]], Response::HTTP_UNAUTHORIZED);
    }

    public function verify($email)
    {
        if (! request()->hasValidSignature()) {
            abort(401);
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return response('Not able to verify email.', 404);
        }

        $user->email_verified_at = now();
        $user->save();
        return redirect('http://localhost:3000/login?verified=true');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged out successfully.']);
    }
}
