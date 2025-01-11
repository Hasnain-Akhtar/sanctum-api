<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validate the request data
        $validatorUser = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // If the validation fails, return an error response
        if ($validatorUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request data',
                'errors' => $validatorUser->errors()->all(),
            ], 401);
        }

        // Create a new user
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Save the user
        $user->save();

        // Return a successful response
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validatorUser = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        // If the validation fails, return an error response
        if ($validatorUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request data',
                'errors' => $validatorUser->errors()->all(),
            ], 401);
        }

        // Attempt to authenticate the user with the provided credentials
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Generate a Sanctum token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return a successful response with the token
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        }

        // Return an error response if authentication fails
        return response()->json([
            'error' => 'Invalid credentials',
        ], 401);
    }

    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Delete the user's token
        $user->tokens()->delete();

        // Return a successful response
        return response()->json([
            'status' => true,
            'message' => 'You have successfully logout',
            'user' => $user,
        ], 200);
    }
}

