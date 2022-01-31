<?php

namespace App\Entities\Twitter;

use Natsumeaurlia\Reflection\PropertyReflector;

/**
 * @see https://developer.twitter.com/en/docs/twitter-api/v1/data-dictionary/object-model/tweet
 */
final class Tweet extends PropertyReflector
{
    protected $created_at;
    protected $id;
    protected $id_str;
    protected $text;
    protected $truncated;
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
    protected $retweet_count;
    protected $favorite_count;
    protected $favorited;
    protected $retweeted;
    protected $possibly_sensitive;
    protected $possibly_sensitive_appealable;
    protected $lang;

    public function __get($key)
    {
        return array_key_exists($key, get_object_vars($this)) ? $this->$key : null;
    }
}
