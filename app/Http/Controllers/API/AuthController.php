<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials))
        {
            return response()->json('Unauthorized', 401);
        }

        $user = Auth::user();
        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'accessToken' => $accessToken
        ], 200);
    }
}
