<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\StoreLoginRequest;
use App\Services\LoginRateLimitService;

class AuthController extends Controller
{
    public function register(StoreRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return createdResponse($user, 'User registered successfully');
    }

    public function login(StoreLoginRequest $request)
    {
        $service = app(LoginRateLimitService::class);

        $email = $request->email;
        $ip = $request->ip();

        $check = $service->check($email, $ip);

        if ($check['blocked']) {

            return response()->json([
                'message' => 'you are blocked due to too many attempts',
                'retry_after_seconds' => $check['retry_after'],
            ], 429);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {

            $service->failed($email, $ip);

            return unauthorizedResponse('Invalid email or password');
        }

        $service->success($email, $ip);

        return successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
        ], 'User logged in successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
