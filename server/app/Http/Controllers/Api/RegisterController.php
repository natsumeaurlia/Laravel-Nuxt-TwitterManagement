<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\UseCases\User\StoreAction;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, StoreAction $store)
    {
        $user = $store->handle($request->name, $request->email, $request->password);

        return new RegisterResource($user);
    }
}