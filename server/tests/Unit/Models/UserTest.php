<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\AccountTransition;
use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_relation()
    {
        $accountNum = 2;
        $taskNum = 5;
        $user = User::factory()
            ->has(Account::factory()
                ->has(Task::factory()
                    ->count($taskNum))
                ->count($accountNum))
            ->create();

        $this->assertCount($accountNum, $user->accounts()->get());
        $this->assertCount($accountNum * $taskNum, $user->tasks()->get());
    }
}
