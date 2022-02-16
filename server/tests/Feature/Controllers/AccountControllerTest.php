<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\User;
use App\UseCases\Account\Exception\MissingCredentialException;
use App\UseCases\Account\StoreWithCredentials;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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

    public function test_store_accounts()
    {
        $account = Account::factory()->create(['user_id' => $this->user->id]);
        $this->mock(StoreWithCredentials::class, function (MockInterface $mock) use ($account) {
            $mock->shouldReceive('__invoke')->once()->andReturn($account);
        });

        $response = $this->actingAs($this->user)->postJson(route('api.v1.accounts.store', [
            'accessToken' => $this->faker->text(25),
            'accessTokenSecret' => $this->faker->text(25),
            'consumerKey' => $this->faker->text(25),
            'consumerSecret' => $this->faker->text(25),
        ]));

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'id' => $account->id,
                    'name' => $account->name,
                    'screen_name' => $account->screen_name,
                    'avatar_path' => $account->avatar_path
                ]]);
        $this->assertFalse(isset($response['data']['access_token']));
        $this->assertFalse(isset($response['data']['access_token_secret']));
    }

    public function test_failed_store_accounts()
    {
        $this->mock(StoreWithCredentials::class, function (MockInterface $mock) {
            $mock->shouldReceive('__invoke')->once()->andThrow(MissingCredentialException::class);
        });

        $response = $this->actingAs($this->user)->postJson(route('api.v1.accounts.store', [
            'accessToken' => $this->faker->text(25),
            'accessTokenSecret' => $this->faker->text(25),
            'consumerKey' => $this->faker->text(25),
            'consumerSecret' => $this->faker->text(25),
        ]));

        $response->assertStatus(422);
    }
}
