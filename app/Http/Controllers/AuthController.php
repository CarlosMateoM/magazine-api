<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthService;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use PhpParser\Node\Expr\Throw_;

class AuthController extends Controller
{
    public function __construct(public AuthService $authService)
    {

    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse|array
    {
        $credentials = $request->only('email', 'password');
        return $this->authService->login($credentials);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
       return $this->authService->logout($request);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->sendEmailResetPassword($request->validated());
        return response()->json(['message' => 'Correo de recuperacion enviado exitosamente'], 200);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPasswordAction($request->validated());
        return response()->json(['message' => 'Contraseña restablecida exitosamente'],200);
    }
}
