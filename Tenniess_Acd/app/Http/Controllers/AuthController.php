<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use  App\Http\Requests\StoreRegisterRequest;
use  App\Http\Requests\StoreLoginRequest;
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

        $credentials = $request->only('email', 'password');


        if (!$token = auth()->attempt($credentials)) {
            return unauthorizedResponse('Invalid email or password');
        }

        return successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 'User logged in successfully');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    }


