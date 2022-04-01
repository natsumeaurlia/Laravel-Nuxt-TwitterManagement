<?php

namespace Tests\Unit\UseCases\Account;

use App\Entities\Twitter\User;
use App\Models\Account;
use App\Services\TwitterApiService;
use App\UseCases\Account\Exception\MissingCredentialException;
use App\UseCases\Account\StoreWithCredentials;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;
use App\Models\User as UserModel;

class StoreWithCredentialsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_should_save_account()
    {
        $attr = [
            'id' => $this->faker->randomDigit(),
            'name' => $this->faker->name,
            'screen_name' => $this->faker->name,
            'profile_image_url' => $this->faker->url
        ];

        $this->mock(TwitterApiService::class, function (MockInterface $mock) use ($attr) {
            $mock->shouldReceive('usingCredentials')->once()
                ->andReturn($mock);
            $mock->shouldReceive('getCredentials')->once()
                ->andReturn(new User($attr));
        });
        $usecase = app()->make(StoreWithCredentials::class);
        $user = UserModel::factory()->create();
        $account = $usecase($user, 'accessToken', 'accessTokenSecret', 'consumerKey', 'consumerSecret');
        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals($user->id, $account->user_id);
        $this->assertEquals($attr['id'], $account->id);
        $this->assertEquals($attr['name'], $account->name);
        $this->assertEquals($attr['screen_name'], $account->screen_name);
        $this->assertEquals($attr['profile_image_url'], $account->avatar_path);
    }

    public function test_failed_invalid_credentials()
    {
        $this->mock(TwitterApiService::class, function (MockInterface $mock) {
            $mock->shouldReceive('usingCredentials')->once()
                ->andReturn($mock);
            $mock->shouldReceive('getCredentials')->once()
                ->andReturn(null);
        });
        $usecase = app()->make(StoreWithCredentials::class);
        $user = UserModel::factory()->create();

        // 例外が投げられること
        $this->expectException(MissingCredentialException::class);
        $usecase($user, 'accessToken', 'accessTokenSecret', 'consumerKey', 'consumerSecret');
    }
}
