<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::query()
            ->where('email', $data['email'])
            ->first();
        if (!$user || !password_verify($data['password'], $user->password)) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Invalid credentials',
                ],
                401
            );
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
                'message' => 'Login successful',
            ],
            200
        );
    }
}
