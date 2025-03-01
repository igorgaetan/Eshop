<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionnaireController extends Controller
{
    public function login(Request $request)
    {
         
      
       $credentials = $request->only('login', 'password');
        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function user()
    {
      
     return response ([
         'user'=> auth() -> user ()
     ], 200);
    }

    public function logout()
    {

        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response(["message" => "deconnexion"], 200);
    }
}
