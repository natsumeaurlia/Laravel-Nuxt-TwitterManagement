<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\AccountTransition;
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
            ->create();

        $this->assertNotNull($account->user()->first());
        $this->assertNotNull($account->accountTransitions()->get());
        $this->assertCount(3, $account->accountTransitions()->get());
    }
}
