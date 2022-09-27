<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\User\UserResource;
use App\Models\User;
use http\Client\Response;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required|confirmed"
            ]);
            if ($validateUser->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "validation errors",
                    "errors" => $validateUser->errors()
                ], 401);
            }
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            $user->userInfo()->create([
                'slug' => Str::slug($request->name)
            ]);
            return response()->json([
                "success" => true,
                "message" => "user created success",
                "data" => [
                    "user" => new UserResource($user),
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
     * @return
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
                "message" => "user login In Success",
                "data" => [
                    "user" => new UserResource($user),
                    'access_token' => $user->createToken("login_user")->plainTextToken,
                    'token_type' => 'Bearer',
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);
        $user = User::findOrFail($request->user_id);
        $user->tokens()->delete();
        //auth()->user()->tokens()->delete();
        return response()->json([
            "success" => true
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function forgotPassword(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "email" => "required|email",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "validator error",
                    "errors" => $validate->errors()
                ], 401);
            }

            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                return [
                    "message" => "email de renitialisation du mot de passe envoyé " //. __($status)
                ];
            }
            throw ValidationException::withMessages([
                "email" => [trans($status)]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    "password" => Hash::make($request->password),
                    "remember_token" => Str::random(60)
                ])->save();

                $user->tokens()->delete();
                event(new PasswordReset($user));
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return response([
                "message" => "Password reset successufully"
            ]);
        }
        return response([
            "message" => __($status)
        ], 500);
    }
}
