<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthAPIController extends Controller
{
    public function login(Request $req)
    {
        $data = $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user)
        {
            return response(['Result' => 'No user was found with this email'], 404);
        }
        if(!Hash::check($data['password'], $user->password))
        {
            return response(['Result' => 'Password is incorrect'], 401);
        }

        $token = $user->createToken('my_app_token')->plainTextToken;

        return response(['token' => $token], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return ['message' => 'Logged out'];
    }
}
