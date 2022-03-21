<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\CustomerRegisterRequest;
use App\Repositories\UserRepository;

use Auth;

/**
 * @group Authentication API
 * APIs for login, account verification, reset password, and customer registration
 */

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Auth user login
     */
    public function login(LoginRequest $request)
    {
        return $request->validated();

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

    /**
     * Auth customer user registration
     */
    public function register(CustomerRegisterRequest $request)
    {
        return $request->validated();
        return $this->userRepository->create($request->except('address'), $request->address);
    }
}
