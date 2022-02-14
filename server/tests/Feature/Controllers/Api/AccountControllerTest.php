<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_no_accounts()
    {
        $response = $this->actingAs($this->user)->getJson(route('api.v1.accounts.index'));
        $response->assertSuccessful();
        $this->assertCount(0, $response['data']);
    }

    public function test_index_accounts()
    {
        Account::factory()->count(3)->for($this->user)->create();
        $response = $this->actingAs($this->user)->getJson(route('api.v1.accounts.index'));
        $response->assertSuccessful();
        $this->assertCount(3, $response['data']);
    }

}
