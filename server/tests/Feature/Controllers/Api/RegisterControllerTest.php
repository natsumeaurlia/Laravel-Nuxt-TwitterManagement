<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_register()
    {
        $user = User::factory()->make();
        $response = $this->postJson(route('api.v1.auth.register'), $user->only(['name', 'email', 'password']));
        $response->assertSuccessful();
        $this->assertDatabaseHas($user, ['email' => $user->email]);
    }

    public function test_failed_only_unique_email()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('api.v1.auth.register'), $user->only(['name', 'email', 'password']));
        $response->assertStatus(422);
    }
}
