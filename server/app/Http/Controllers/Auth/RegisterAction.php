<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\UseCases\User\Store;

class RegisterAction extends Controller
{
    public function __invoke(RegisterRequest $request, Store $store)
    {
        $user = $store->handle($request->name, $request->email, $request->password);

        return new RegisterResource($user);
    }
}
