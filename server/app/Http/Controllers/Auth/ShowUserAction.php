<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ShowUserAction extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }
}
