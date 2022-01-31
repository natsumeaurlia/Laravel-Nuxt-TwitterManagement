<?php

namespace App\Entities\Twitter;

use Natsumeaurlia\Reflection\PropertyReflector;

class User extends PropertyReflector
{
    protected $id;
    protected $id_str;
    protected $name;
    protected $screen_name;
    protected $location;
    protected $profile_location;
    protected $description;
    protected $url;
    protected $entities;
    protected $protected;
    protected $followers_count;
    protected $friends_count;
    protected $listed_count;
    protected $created_at;
    protected $favourites_count;
    protected $utc_offset;
    protected $time_zone;
    protected $geo_enabled;
    protected $verified;
    protected $statuses_count;
    protected $lang;
    protected $contributors_enabled;
    protected $is_translator;
    protected $is_translation_enabled;
    protected $profile_background_color;
    protected $profile_background_image_url;
    protected $profile_background_image_url_https;
    protected $profile_background_tile;
    protected $profile_image_url;
    protected $profile_image_url_https;
    protected $profile_banner_url;
    protected $profile_link_color;
    protected $profile_sidebar_border_color;
    protected $profile_sidebar_fill_color;
    protected $profile_text_color;
    protected $profile_use_background_image;
    protected $has_extended_profile;
    protected $default_profile;
    protected $default_profile_image;
    protected $following;
    protected $follow_request_sent;
    protected $notifications;
    protected $translator_type;

    public function __get($key)
    {
        return array_key_exists($key, get_object_vars($this)) ? $this->$key : null;
    }
}
