<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\UseCases\User\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_login()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => $password]);
        $response = $this->postJson(route('api.auth.login'), ['email' => $user->email, 'password' => $password]);
        $response->assertStatus(200)
            ->assertJson(['name' => $user->name, 'email' => $user->email]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_failed_login()
    {
        $this->mock(Login::class, function ($mock) {
            $mock->shouldReceive('handle')->once()->andReturn(null);
        });
        $password = 'password';
        $user = User::factory()->create(['password' => $password]);
        $response = $this->postJson(route('api.auth.login'), ['email' => $user->email, 'password' => $password]);
        $response->assertUnprocessable();
    }

    public function test_failed_login_only_guest()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => $password]);
        $response = $this->actingAs($user)->postJson(route('api.auth.login'), ['email' => $user->email, 'password' => $password]);
        $response->assertStatus(403);
    }
}
