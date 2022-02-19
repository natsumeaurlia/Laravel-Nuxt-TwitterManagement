<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\UseCases\User\Store;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, Store $store)
    {
        $user = $store->handle($request->name, $request->email, $request->password);

        return new RegisterResource($user);
    }
}
