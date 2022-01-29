<?php

namespace App\UseCases\Twitter;

use App\Entities\Twitter\Tweet;
use App\Services\TwitterApiService;

class RetweetExcludeAlready implements ActionInterface
{
    protected $service;

    public function __construct(TwitterApiService $service)
    {
        $this->service = $service;
    }

    public function handle(Tweet $tweet)
    {
        if ($this->exclude($tweet)) {
            return null;
        }
        return $this->service->postRetweet($tweet->id);
    }

    protected function exclude(Tweet $tweet)
    {
        return $tweet->retweeted;
    }
}
