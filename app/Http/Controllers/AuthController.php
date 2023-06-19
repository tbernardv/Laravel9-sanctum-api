<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        //Check email
        $user = User::where('email', $fields['email'])->first();

        //Check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response()->json([
                'message' => 'Bad credentials!'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out! GOD BLESS!!'
        ]);
    }
}
