<?php

namespace App\UseCases\Task;

use App\Entities\Twitter\Tweet;

interface ActionInterface
{
    public function handle(Tweet $tweet);
}
