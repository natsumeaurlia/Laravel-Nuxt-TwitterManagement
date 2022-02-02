<?php

namespace App\UseCases\Task;

use App\Entities\Twitter\Tweet;
use App\Services\TwitterApiService;

class FollowExcludeFollower implements ActionInterface
{
    protected TwitterApiService $service;

    public function __construct(TwitterApiService $service)
    {
        $this->service = $service;
    }

    public function handle(Tweet $tweet)
    {
        if ($this->exclude($tweet)) {
            return null;
        }
        return $this->service->postFollow($tweet->user->id);
    }

    protected function exclude($tweet): bool
    {
        return $tweet->user ? $tweet->user->following : false;
    }
}
