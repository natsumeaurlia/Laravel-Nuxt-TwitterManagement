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
        $response = $this->actingAs($this->user)->getJson(route('api.accounts.index'));
        $response->assertSuccessful();
        $this->assertCount(0, $response->decodeResponseJson());
    }

    public function test_index_accounts()
    {
        Account::factory()->count(3)->for($this->user)->create();
        $response = $this->actingAs($this->user)->getJson(route('api.accounts.index'));
        $response->assertSuccessful();
        $this->assertCount(3, $response->decodeResponseJson());
    }

    public function test_store_accounts()
    {
        $account = Account::factory()->create(['user_id' => $this->user->id]);
        $this->mockStoreWithCredentials($account);

        $response = $this->actingAs($this->user)->postJson(route('api.accounts.store'), $this->makeToken());

        $response->assertSuccessful()
            ->assertJson([
                'id' => $account->id,
                'name' => $account->name,
                'screen_name' => $account->screen_name,
                'avatar_path' => $account->avatar_path
            ]);
        $this->assertFalse(isset($response['access_token']));
        $this->assertFalse(isset($response['access_token_secret']));
    }

    public function test_failed_store_accounts()
    {
        $this->mock(StoreWithCredentials::class, function (MockInterface $mock) {
            $mock->shouldReceive('__invoke')->once()->andThrow(MissingCredentialException::class);
        });

        $response = $this->actingAs($this->user)->postJson(route('api.accounts.store'), $this->makeToken());

        $response->assertStatus(422);
    }

    public function test_update_token()
    {
        $account = Account::factory()->create(['user_id' => $this->user->id]);

        // token系はhiddenにしているため、一度保管
        $keys = $this->makeToken();
        $updatedAccount = Account::factory()->make(array_merge(['id' => $account->id], $keys));
        $this->mockStoreWithCredentials($updatedAccount);

        $response = $this->actingAs($this->user)
            ->postJson(route('api.accounts.store'), $keys);

        $response->assertStatus(200)->assertJson([
            'id' => $account->id,
            'name' => $updatedAccount->name,
            'screen_name' => $updatedAccount->screen_name,
            'avatar_path' => $updatedAccount->avatar_path
        ]);
        $this->assertFalse(isset($response['access_token']));
        $this->assertFalse(isset($response['access_token_secret']));
    }

    public function test_show_my_account()
    {
        $account = Account::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->getJson(route('api.accounts.show', ['account' => $account->id]));
        $response->assertStatus(200)->assertJson(['id' => $account->id, 'name' => $account->name]);
    }

    public function test_show_not_allow_other_user_account()
    {
        $otherUser = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $otherUser->id]);
        $response = $this->actingAs($this->user)->getJson(route('api.accounts.show', ['account' => $account->id]));
        $response->assertStatus(403);
    }

    public function test_delete_account()
    {
        $account = Account::factory()->create(['user_id' => $this->user->id]);

        $this->assertDatabaseHas('accounts', ['id' => $account->id]);
        $response = $this->actingAs($this->user)
            ->deleteJson(route('api.accounts.destroy', ['account' => $account->id]));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('accounts', ['id' => $account->id]);
    }

    public function test_failed_delete_other_user_account()
    {
        $otherUser = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $otherUser->id]);

        $this->assertDatabaseHas('accounts', ['id' => $account->id]);
        $response = $this->actingAs($this->user)
            ->deleteJson(route('api.accounts.destroy', ['account' => $account->id]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('accounts', ['id' => $account->id]);
    }

    /**
     * @param Account $account
     * @return void
     */
    private function mockStoreWithCredentials(Account $account): void
    {
        $this->mock(StoreWithCredentials::class, function (MockInterface $mock) use ($account) {
            $mock->shouldReceive('__invoke')->once()->andReturn($account);
        });
    }

    /**
     * @return array
     */
    private function makeToken(): array
    {
        return [
            'accessToken' => $this->faker->text(25),
            'accessTokenSecret' => $this->faker->text(25),
            'consumerKey' => $this->faker->text(25),
            'consumerSecret' => $this->faker->text(25),
        ];
    }

}
