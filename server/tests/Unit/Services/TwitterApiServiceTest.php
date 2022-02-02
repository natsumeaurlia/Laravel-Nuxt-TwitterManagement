<?php

namespace Tests\Unit\Services;

use App\Entities\Twitter\Tweet;
use App\Entities\Twitter\User;
use App\Services\TwitterApiService;
use Atymic\Twitter\ApiV1\Service\Twitter;
use Atymic\Twitter\Exception\Request\ForbiddenRequestException;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;
use \RuntimeException;

class TwitterApiServiceTest extends TestCase
{
    public function testGetUser()
    {
        $response = [
            'id' => 123456789,
            'id_str' => '123456789',
            'name' => 'example',
            'screen_name' => 'ex'
        ];
        $this->mock(Twitter::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('getUsers')->once()->andReturn((object)$response);
        });

        $api = $this->app->make(TwitterApiService::class);
        $user = $api->getUser('example');

        $this->assertTrue($user instanceof User);
        $this->assertEquals($user->id, $response['id']);
        $this->assertEquals($user->name, $response['name']);

    }

    public function testFailedGetUser()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('getUsers')
                ->once()
                ->andThrow(new RuntimeException());
        });
        $api = $this->app->make(TwitterApiService::class);
        $user = $api->getUser('example');
        $this->assertNull($user);
    }

    public function testGetTweets()
    {
        $response = [
            'statuses' => [
                [
                    'created_at' => 'Tue Jan 17 23:36:48 +0000 2017',
                    'id' => 123456789,
                    'id_str' => '123456789',
                    'text' => 'hello'
                ],
                [
                    'created_at' => 'Tue Jan 17 23:36:48 +0000 2017',
                    'id' => 12345678910,
                    'id_str' => '12345678910',
                    'text' => 'hello 2'
                ],
            ],
            'search_metadata' => [
                'count' => 2,
                'since_id' => 0,
                'since_id_str' => 0,
            ]
        ];
        $this->mock(Twitter::class, function (MockInterface $mock) use ($response) {
            $mock->shouldReceive('getSearch')
                ->once()
                ->andReturn((object)$response);
        });
        $api = $this->app->make(TwitterApiService::class);
        $tweets = $api->getTweets('hello', 2, 'mixed');
        $this->assertTrue($tweets instanceof Collection);
        $this->assertCount(2, $tweets);
        $tweets->each(function ($item) {
            $this->assertTrue($item instanceof Tweet);
        });
    }

    public function testFailedGetTweets()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('getSearch')
                ->once()
                ->andThrow(new RuntimeException());
        });
        $api = $this->app->make(TwitterApiService::class);
        $tweets = $api->getTweets('hello', 2, 'mixed');
        $this->assertEmpty($tweets);
        $this->assertCount(0, $tweets);
    }

    public function testPostFavorite()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('postFavorite')
                ->once()
                ->andReturn((object)[
                    'created_at' => 'Tue Jan 17 23:36:48 +0000 2017',
                    'id' => 123456789,
                    'id_str' => '123456789',
                    'text' => 'hello',
                    'favorited' => true
                ]);
        });
        $api = $this->app->make(TwitterApiService::class);
        $tweet = $api->postFavorite(123456789);
        $this->assertTrue($tweet);
    }

    public function testFailedPostFavorite()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('postFavorite')
                ->once()
                ->andThrow(new ForbiddenRequestException());
        });
        $api = $this->app->make(TwitterApiService::class);
        $tweet = $api->postFavorite(123456789);
        $this->assertFalse($tweet);
    }

    public function testPostFollow()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('postFollow')
                ->once()
                ->andReturn((object)[
                    'id' => 123456789,
                    'id_str' => '123456789',
                    'name' => 'example',
                    'screen_name' => 'ex',
                    'following' => true
                ]);
        });
        $api = $this->app->make(TwitterApiService::class);
        $user = $api->postFollow(123456789);
        $this->assertTrue($user);
    }

    public function testFailedPostFollow()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('postFollow')
                ->once()
                ->andThrow(new RuntimeException());
        });
        $api = $this->app->make(TwitterApiService::class);
        $user = $api->postFollow(123456789);
        $this->assertFalse($user);
    }

    public function testPostRetweet()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('postRt')
                ->once()
                ->andReturn((object)[
                    'created_at' => 'Tue Jan 17 23:36:48 +0000 2017',
                    'id' => 123456789,
                    'id_str' => '123456789',
                    'text' => 'hello'
                ]);
        });
        $api = $this->app->make(TwitterApiService::class);
        $tweet = $api->postRetweet(123456789);
        $this->assertTrue($tweet);
    }

    public function testFailedPostRetweet()
    {
        $this->mock(Twitter::class, function (MockInterface $mock) {
            $mock->shouldReceive('postRt')
                ->once()
                ->andThrow(new RuntimeException());
        });
        $api = $this->app->make(TwitterApiService::class);
        $tweet = $api->postRetweet(123456789);
        $this->assertFalse($tweet);
    }
}
