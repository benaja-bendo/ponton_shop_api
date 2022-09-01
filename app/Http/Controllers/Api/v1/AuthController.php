<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required"
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "validation error",
                    "errors" => $validateUser->errors()
                ], 401);
            }
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            return response()->json([
                "success" => true,
                "message" => "user created successfully",
                "data" => [
                    "user" => $user,
                    'access_token' => $user->createToken("create_user")->plainTextToken,
                    'token_type' => 'Bearer',
                ]
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * login User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validatUser = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required"
            ]);

            if ($validatUser->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "validator error",
                    "errors" => $validatUser->errors()
                ], 401);
            }
            if (!Auth::attempt($request->only(["email", "password"]))) {
                return response()->json([
                    "success" => false,
                    "message" => "identifiants non valide"
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
                "success" => true,
                "message" => "user Logged In Successefully",
                "data" => [
                    "user" => $user,
                    'access_token' => $user->createToken("create_user")->plainTextToken,
                    'token_type' => 'Bearer',
                ]
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            "status" => true,
            "message" => "Logged out",
        ];
    }
}
