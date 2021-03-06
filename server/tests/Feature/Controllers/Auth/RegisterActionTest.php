<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_register()
    {
        $user = User::factory()->make();
        $response = $this->postJson(route('api.auth.register'), $user->only(['name', 'email', 'password']));
        $response->assertCreated()
            ->assertJson(['name' => $user->name, 'email' => $user->email]);
        $this->assertDatabaseHas($user, ['email' => $user->email]);
    }

    public function test_failed_only_unique_email()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('api.auth.register'), $user->only(['name', 'email', 'password']));
        $response->assertStatus(422);
    }

    public function test_failed_only_guest()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('api.auth.register'), $user->only(['name', 'email', 'password']));
        $response->assertStatus(403);
    }
}
