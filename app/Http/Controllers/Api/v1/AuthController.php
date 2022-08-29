<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "user created successfully",
            "data" => [
                "user" => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }

    public function loginUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "login successfully",
            "data" => [
                "user" => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email|max:255',
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        // if ($status == Password::RESET_LINK_SENT) {
        //     return [
        //         'status' => __($status)
        //     ];
        // }
        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
