<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'login' => 'required|string|unique:users,login',
            'password' => 'required|string|confirmed',  
            'email' => 'required|string|unique:users,email'
        ]);

        $user = User::create([
            'login' => $data['login'],
            'password' => bcrypt($data['password']),  
            'email' => $data['email']
        ]);

        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $data = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',  
            'email' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
