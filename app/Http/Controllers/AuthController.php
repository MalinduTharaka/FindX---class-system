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
            'role' => $user->role, // Assuming `role` is a column in your users table
            'name' => $user->name,
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

    //for mobile APIs

        public function sendResetOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $token = Str::random(60);

        // Store OTP and token in the database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Send OTP via email (using Laravel Mail)
        Mail::raw("Your password reset OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject("Password Reset OTP");
        });

        return response()->json([
            'message' => 'OTP sent to email.',
            'token' => $token // Optionally return the token
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'token' => 'required',
            
        ]);

        // Check if OTP and token are valid
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        return response()->json(['message' => 'otp is verified.',
            'otp' => $request->otp,
            'token' => $request->token,]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        // Check if OTP and token are valid
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid OTP or token'], 400);
        }

        // Update user's password
        User::where('email', $request->email)->update([
            'password' => bcrypt($request->password)
        ]);

        // Delete reset request after successful password update
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successful.']);
    }


}

    

