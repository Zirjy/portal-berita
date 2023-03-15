<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;




class Autenticationcontroller extends Controller
{
    public function login(Request $request)
    {
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // dd($user);
        if (!$user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'account' => ['You are A White Guys!'],
            ]);
        };
        return $user->createToken('user login')->plainTextToken;
    }
    public function logout(request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'anda sudah logout']);
    }

    public function me(Request $request){
        $user = Auth::user();
        return response()->json($user);
    }
}
