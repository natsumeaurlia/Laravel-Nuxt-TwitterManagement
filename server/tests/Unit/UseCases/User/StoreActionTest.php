<?php

namespace Tests\Unit\UseCases\User;

use App\Models\User;
use App\UseCases\User\StoreAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_should_save()
    {
        $faker = $this->faker;
        $email = $faker->email;
        $usecase = resolve(StoreAction::class);
        $result = $usecase->handle($faker->name, $email, $faker->password);
        $this->assertEquals(User::class, get_class($result));
        $this->assertDatabaseHas('users', ['email' => $email]);
    }
}
