<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)

    {
        // Log::info('Incoming Register Request:', $request->all());
        // dump($request->all());
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        // Validate input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
    
        // Retrieve the authenticated user
        $user = Auth::user();
    
        // Generate an access token
        $token = $user->createToken('auth_token')->plainTextToken;
    
        // Return response with role and token
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role // Assuming `role` is a column in your users table
        ], 200);
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete(); // Revoke all tokens

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}

    

