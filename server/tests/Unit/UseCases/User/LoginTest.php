<?php

namespace Tests\Unit\UseCases\User;

use App\Models\User;
use App\UseCases\User\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_should_login()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => $password]);

        $usecase = resolve(Login::class);
        $result = $usecase->handle($user->email, $password);
        $this->assertNotNull($result);
        $this->assertTrue($user->is($result));
        $this->assertAuthenticatedAs($result);
    }

    public function test_failed_login_missing_credentials()
    {
        $user = User::factory()->create(['password' => 'password']);

        $usecase = resolve(Login::class);
        $result = $usecase->handle($user->email, 'missing');
        $this->assertNull($result);
    }
}
