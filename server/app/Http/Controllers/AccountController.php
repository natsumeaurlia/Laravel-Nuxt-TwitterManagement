<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreOrUpdateRequest;
use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\UseCases\Account\Exception\MissingCredentialException;
use App\UseCases\Account\StoreWithCredentials;
use Illuminate\Http\Response;
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

    public function store(StoreOrUpdateRequest $request, StoreWithCredentials $store)
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
        return (new AccountResource($storedAccount))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            return response()->json(['message' => 'account not found.'], Response::HTTP_NOT_FOUND);
        }
        return new AccountResource($account);
    }

    public function update(StoreOrUpdateRequest $request, StoreWithCredentials $store)
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

    public function destroy(Account $account)
    {
        if ($account->user_id === Auth::id() && $account->delete()) {
            return response()->json(['message' => 'account deleted.']);
        }
        return response()->json(['message' => 'account not found.'], Response::HTTP_NOT_FOUND);
    }
}
