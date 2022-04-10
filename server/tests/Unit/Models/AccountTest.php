<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\AccountTransition;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_relation()
    {
        /** @var Account $account */
        $account = Account::factory()
            ->has(AccountTransition::factory()->count(3), 'accountTransitions')
            ->has(Task::factory()->count(5))
            ->create();

        $this->assertNotNull($account->user()->first());
        $this->assertCount(3, $account->accountTransitions()->get());
        $this->assertCount(5, $account->tasks()->get());
    }
}
