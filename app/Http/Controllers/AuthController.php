<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Dotenv\Exception\ValidationException;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use PhpParser\Node\Expr\Throw_;

class AuthController extends Controller
{
    public function __construct()
    {

    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse|array
    {
        $credentials = $request->only('email', 'password');

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
}
