<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\LoginResource;
use App\UseCases\User\Login;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, Login $login)
    {
        if ($user = $login->handle($request->email, $request->password)) {
            return new LoginResource($user);
        }
        return response()->json(['message' => 'failed login'], 422);
    }
}
