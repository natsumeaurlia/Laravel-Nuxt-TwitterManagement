<?php

namespace App\UseCases\User;

use App\Models\User;

class StoreAction
{
    protected User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function handle($name, $email, $password): User
    {
        return $this->model->create(compact('name', 'email', 'password'));
    }
}
