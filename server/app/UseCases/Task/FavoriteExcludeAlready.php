<?php

namespace App\UseCases\Task;

use App\Entities\Twitter\Tweet;
use App\Services\TwitterApiService;

class FavoriteExcludeAlready implements ActionInterface
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
        return $this->service->postFavorite($tweet->id);
    }

    protected function exclude(Tweet $tweet): bool
    {
        return $tweet->favorited;
    }
}
