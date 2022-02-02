<?php

namespace App\UseCases\User;

use Illuminate\Auth\AuthManager;
use App\Models\User;

class Login
{
    protected $guard;

    public function __construct(AuthManager $auth)
    {
        $this->guard = $auth->guard();
    }

    public function handle($email, $password): ?User
    {
        if ($this->guard->attempt(['email' => $email, 'password' => $password])) {
            return $this->guard->user();
        }
        return null;
    }
}
