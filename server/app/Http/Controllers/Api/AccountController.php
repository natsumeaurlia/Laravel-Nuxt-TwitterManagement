<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AccountCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $accounts = $user->accounts()->get();
        return new AccountCollection($accounts);
    }

    public function store(Request $request)
    {
       //
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
