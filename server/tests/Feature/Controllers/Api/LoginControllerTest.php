<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use App\UseCases\User\LoginAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_should_login()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => $password]);
        $response = $this->postJson(route('api.v1.auth.login'), ['email' => $user->email, 'password' => $password]);
        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => $user->name, 'email' => $user->email]]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_failed_login()
    {
        $this->mock(LoginAction::class, function ($mock) {
            $mock->shouldReceive('handle')->once()->andReturn(null);
        });
        $password = 'password';
        $user = User::factory()->create(['password' => $password]);
        $response = $this->postJson(route('api.v1.auth.login'), ['email' => $user->email, 'password' => $password]);
        $response->assertUnprocessable();
    }
}
