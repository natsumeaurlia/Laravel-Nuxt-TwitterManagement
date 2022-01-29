<?php

namespace App\UseCases\Twitter;

use App\Entities\Twitter\Tweet;

interface ActionInterface
{
    public function handle(Tweet $tweet);
}
