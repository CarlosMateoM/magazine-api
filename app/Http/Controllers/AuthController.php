<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Services\AuthService;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(public AuthService $authService)
    {

    }

    public function register(StoreUserRequest $request)
    {
        return $this->authService->registerNewUser($request->validated());
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

    /**
     * @throws ValidationException
     */
    public function verifyEmail(VerifyEmailRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->emailVerification($request->validated());
    }

    public function resendEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->resendVerificationEmail($request);
    }
}
