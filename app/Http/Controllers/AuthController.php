<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        ray($request->validated());
        return $request->validated();
    }

    // this method signs out users by removing tokens
    public function signout()
    {
        ray(auth()->user()->tokens);
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Tokens Revoked'
        ];
    }


    public function updateFcmToken(Request $request)
    {
        $validated = $request->validate([
            'fcm_token'=>'nullable|string'
            ]);
        return Auth::user()->update(['fcm_token'=>$validated['fcm_token']]);
    }

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type'=>'required',
        ]);
        $attr['password'] = Hash::make($attr['password']);
        $user = User::create($attr);
        Auth::attempt($attr);
        return array_merge($user->toArray(),['token'=>$user->createToken('tokens')->plainTextToken]);
    }
}
