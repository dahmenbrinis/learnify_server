<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
//            'device_name' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response(['message'=>'Credentials not match'],500);
        }
        $user = auth()->user();
        return array_merge($user->toArray(),['token'=>$user->createToken('tokens')->plainTextToken]);
    }

    // this method signs out users by removing tokens
    public function signout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }


    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type'=>'required',
        ]);

        $user = User::create($attr);
        Auth::attempt($attr);
        return array_merge($user->toArray(),['token'=>$user->createToken('tokens')->plainTextToken]);
    }
}
