<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class TaskType extends Enum implements LocalizedEnum
{
    public const FOLLOW = 'follow';
    public const UNFOLLOW = 'unfollow';
    public const FAVORITE = 'favorite';
    public const RETWEET = 'retweet';
}
