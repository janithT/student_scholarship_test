<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(public AuthService $authService) {}

    /**
     * Register student.
     * 
     */

    public function register(RegisterRequest $request)
    {

        $student = $this->authService->studentRegister($request->validated());

        if ($student->status) {
            return apiResponseWithStatusCode($student->data, 'success', 'You have successfully registered', '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $student->message, '', 422);
    }


    /**
     * Login student.
     * 
     */

    public function login(LoginRequest $request)
    {

        $login = $this->authService->studentLogin($request->validated());

        if ($login->status) {
            return apiResponseWithStatusCode($login->data, 'success', 'You have successfully logged in', '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $login->message, '', 401);
        
    }
}
