<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;

use Auth;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

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

    public function register(Request $request)
    {
        return $this->userRepository->create($request->except('address'), $request->address);
    }
}

// TODO: Add request validation
