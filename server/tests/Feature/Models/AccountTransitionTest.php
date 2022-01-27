<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\AccountTransition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTransitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_relation()
    {
        /** @var AccountTransition $transition */
        $transition = AccountTransition::factory()
            ->for(Account::factory()->create())
            ->create();

        $this->assertNotNull($transition->account()->first());
    }
}
