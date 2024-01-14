<?php

namespace App\Http\Controllers\V1;

use App\Enums\Http\StatusCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\ErrorResource;
use App\Http\Resources\V1\LoginResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return (new ErrorResource(
                ['message' => __('messages.api.auth.invalid_credentials')]
            ))->response()->setStatusCode(StatusCodeEnum::UNAUTHORIZED->value);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return (new LoginResource(
            ['access_token' => $token, 'token_type' => 'Bearer']
        ))->response()->setStatusCode(StatusCodeEnum::CREATED->value);
    }
}
