<?php

namespace App\Services;

use App\Events\SuccessfulPasswordResetEvent;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\Array_;


class AuthService
{
    public function __construct()
    {

    }

    public function login(Array $credentials): \Illuminate\Http\JsonResponse|array
    {

        try{
            if(!Auth::attempt($credentials)){
                Throw ValidationException::withMessages([
                    "credentials" => ['credenciales invalidas']
                ]);
            }
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return [
                "user" => $user,
                "token" => $token

            ];
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "sesion cerrada exitosamente!"],200);
    }

    public function sendEmailResetPassword(Array $data): void
    {
        $status = Password::sendResetLink($data);

        if($status === Password::INVALID_USER){
            throw ValidationException::withMessages(
                ["email" => "No existe un usuario con ese correo"]
            );
        }

        if ($status === Password::RESET_THROTTLED){
            throw ValidationException::withMessages([
                "email" => "Demasiados intentos. Intentelo nuevamente mas tarde"
            ]);
        }

        if ($status !== Password::RESET_LINK_SENT){
            throw new Exception('Error al enviar el correo');
        }
    }

    public function resetPasswordAction(Array $data){

        $status = Password::reset($data, function (User $user, string $password){

            $user->tokens()->delete();

                $user->forceFill(
                    ['password' => Hash::make($password)]
                );
                $user->save();

                event(new SuccessfulPasswordResetEvent($user['id']));
            });

        if ($status === Password::INVALID_USER) {
            throw ValidationException::withMessages([
                "credentials" => ['Credenciales inválidas']
            ]);
        }

        if ($status === Password::INVALID_TOKEN) {
            throw ValidationException::withMessages([
                "token" => ["Token inválido"]
            ]);
        }

        if ($status === Password::RESET_THROTTLED) {
            throw ValidationException::withMessages([
                'errors' => ['No tiene más intentos. Vuelva a realizar la operación más tarde']
            ]);
        }

        if ($status !== Password::PASSWORD_RESET) {
            throw new Exception('No se pudo restablecer la contraseña. Intenta de nuevo.');
        }

    }

}
