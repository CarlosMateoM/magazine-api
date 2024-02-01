<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function login(){
        return response()->json([
            'message' => 'Login'
        ]);
    }

    public function register(){
        return response()->json([
            'message' => 'Register'
        ]);
    }

    public function logout(){
        return response()->json([
            'message' => 'Logout'
        ]);
    }
}
