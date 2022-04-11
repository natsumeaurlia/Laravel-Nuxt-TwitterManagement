<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->accounts()->exists();
    }

    public function view(User $user, Task $task)
    {
        return $user->tasks()->firstWhere(['uuid' => $task->uuid]);
    }

    public function create(User $user)
    {
        return $user->accounts()->exists();
    }

    public function update(User $user, Task $task)
    {
        return $user->tasks()->firstWhere(['uuid' => $task->uuid]);
    }

    public function delete(User $user, Task $task)
    {
        return $user->tasks()->firstWhere(['uuid' => $task->uuid]);
    }
}
