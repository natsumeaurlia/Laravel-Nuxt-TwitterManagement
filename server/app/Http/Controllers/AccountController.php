<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreRequest;
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
    public function __construct()
    {
        $this->authorizeResource(Account::class, 'account');
    }

    public function index()
    {
        $user = Auth::user();
        $accounts = $user->accounts()->get();
        return new AccountCollection($accounts);
    }

    /**
     * Twitterの認証を用いてアカウントの作成または更新をする
     */
    public function store(StoreRequest $request, StoreWithCredentials $store)
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
        return new AccountResource($storedAccount);
    }

    public function show(Account $account)
    {
        return new AccountResource($account);
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return response()->json(['message' => 'account deleted.']);
    }
}
