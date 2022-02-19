<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\UpdateOrCreateRequest;
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

    public function store(UpdateOrCreateRequest $request, StoreWithCredentials $store)
    {
        $user = Auth::user();
        try {
            $storedAccount = $store(
                $user,
                $request->accessToken,
                $request->accessTokenSecret,
                $request->consumerKey,
                $request->consumerSecret
            );
        } catch (MissingCredentialException $e) {
            throw ValidationException::withMessages(['token' => 'Given invalid token.']);
        }
        return (new AccountResource($storedAccount))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        $user = Auth::user();
        $account = $user->accounts()->find($id);
        if (!$account) {
            return response()->json(['message' => 'account not found.'], 404);
        }
        return new AccountResource($account);
    }

    public function update(UpdateOrCreateRequest $request, StoreWithCredentials $store)
    {
        $user = Auth::user();
        try {
            $updatedAccount = $store(
                $user,
                $request->accessToken,
                $request->accessTokenSecret,
                $request->consumerKey,
                $request->consumerSecret
            );
        } catch (MissingCredentialException $e) {
            throw ValidationException::withMessages(['token' => 'Given invalid token.']);
        }
        return new AccountResource($updatedAccount);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $account = $user->accounts()->find($id);
        if ($account && $account->delete()) {
            return response()->json(['message' => 'account deleted.']);
        }
        return response()->json(['message' => 'account not found.'], 404);
    }
}
