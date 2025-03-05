<?php

namespace App\Services;

use App\Events\SuccessfulPasswordResetEvent;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public function __construct()
    {

    }


    public function registerNewUser(array $data): \Illuminate\Http\JsonResponse
    {

        $newUser = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
            $user->assignRole($data['role']);
            event(new Registered($user));
            return $user;
        });

        return response()->json(["message" => 'Registro exitoso'], 201);

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

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message" => "sesion cerrada exitosamente!"],200);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
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

    /**
     * @throws ValidationException
     */
    public function resetPasswordAction(Array $data): void
    {

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

    /**
     * @throws ValidationException
     */
    public function emailVerification (array $dataVerifyEmail): \Illuminate\Http\JsonResponse
    {
        // Se verifica la fecha de expiracion que se envio
        if(now()->getTimestamp() > $dataVerifyEmail['expires']){
            Throw ValidationException::withMessages(["expires" => ['Enlace expirado. Intentelo con un nuevo enlace']]);
        }

        // se verifica la firma rearmandola y comparandola con la enviada desde la solicitud
        $params = [
            "expires" => $dataVerifyEmail['expires'],
            "id" => $dataVerifyEmail['id'],
            "hash" => $dataVerifyEmail['hash']
        ];

        $signature = hash_hmac('sha256', http_build_query($params), config('app.key'));

        if(!hash_equals($dataVerifyEmail['signature'], $signature)){
            Throw ValidationException::withMessages(["signature" => ['Firma vulnerada. El enlace de verificacion es corrupto']]);
        }

        // si todo sale bien entonces se verifica el correo

        $user = User::findOrFail($dataVerifyEmail['id']);


        if($user->hasVerifiedEmail()){
            return response()->json(['message' => 'El email ya está verificado'], 200);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verificado correctamente'], 200);

    }

    public function resendVerificationEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user(); //recuperacion de usuario autenticado atraves del token

        if($user->hasVerifiedEmail()){
            return response()->json(['message' => 'El email ya esta verificado'], 200);
        }

        $user->sendEmailVerificationNotification();
        return response()->json((['message' => 'Correo de verificacion reenviado']));
    }

}
