<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use App\UseCases\Account\Exception\MissingCredentialException;
use App\UseCases\Account\StoreWithCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $accounts = $user->accounts()->get();
        return new AccountCollection($accounts);
    }

    public function store(Request $request, StoreWithCredentials $store)
    {
        $user = Auth::user();
        try {
            $storedUser = $store($user, $request->accessToken, $request->accessTokenSecret, $request->consumerKey, $request->consumerSecret);
        } catch (MissingCredentialException $e) {
            return ValidationException::withMessages(['token' => 'Given invalid token.']);
        }
        return (new AccountResource($storedUser))->withResponse($request, response()->setStatusCode(201));
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
