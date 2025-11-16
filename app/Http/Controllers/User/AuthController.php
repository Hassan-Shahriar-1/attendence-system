<?php

namespace App\Http\Controllers\User;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Login\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentails = $request->validated();
        if (Auth::attempt($credentails)) {
            $data['user'] = $user = Auth::user();
            $data['token'] = $user->createToken('School')->plainTextToken;
            return ApiResponseHelper::successResponse($data);
        }
        return ApiResponseHelper::errorResponse('wrong credetnails', 401);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return ApiResponseHelper::successResponse([], false, 'logged out successfully');
    }
}
