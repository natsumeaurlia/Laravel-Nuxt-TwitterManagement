<?php

namespace App\Entities\Twitter;

use Carbon\Carbon;
use Natsumeaurlia\Reflection\PropertyReflector;

/**
 * @see https://developer.twitter.com/en/docs/twitter-api/v1/data-dictionary/object-model/tweet
 */
final class Tweet extends PropertyReflector
{
    protected Carbon $created_at;
    protected int $id;
    protected string $id_str;
    protected string $text;
    protected bool $truncated;
    protected $entities;
    protected $extended_entities;
    protected $source;
    protected $in_reply_to_status_id;
    protected $in_reply_to_status_id_str;
    protected $in_reply_to_user_id;
    protected $in_reply_to_user_id_str;
    protected $in_reply_to_screen_name;
    protected User $user;
    protected $geo;
    protected $coordinates;
    protected $place;
    protected $contributors;
    protected $is_quote_status;
    protected int $retweet_count;
    protected int $favorite_count;
    protected bool $favorited;
    protected bool $retweeted;
    protected $possibly_sensitive;
    protected $possibly_sensitive_appealable;
    protected string $lang;

    public function __get($key)
    {
        return array_key_exists($key, get_object_vars($this)) ? $this->$key : null;
    }
}
