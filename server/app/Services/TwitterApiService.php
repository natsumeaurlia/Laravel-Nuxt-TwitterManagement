<?php

namespace App\Services;

use Atymic\Twitter\ApiV1\Service\Twitter;
use \RuntimeException;

class TwitterApiService
{
    private Twitter $twitter;

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * ユーザーの取得
     * limit 900 / 15min
     *
     * @param string|null $screen_name
     * @return \stdClass $user
     */
    public function getUser(string $screen_name = null)
    {
        try {
            $screen_name = str_replace('@', '', $screen_name);
            $user = $this->twitter->getUsers(['screen_name' => $screen_name]);
        } catch (RuntimeException $e) {
            return null;
        }
        return $user;
    }

    /**
     * キーワードからツイートの検索
     * limit 180 / 15min
     *
     * @param string $keyword
     * @param int $count
     * @return array
     */
    public function getTweets(string $keyword, int $count)
    {
        try {
            $tweets = $this->twitter->getSearch(['q' => $keyword, 'count' => $count, 'popular' => 'mixed']);
        } catch (RuntimeException $e) {
            logger()->error('Tweetの取得に失敗しました:' . $e->getMessage());
            return null;
        }
        return $tweets->statuses;
    }

    /**
     * いいねする
     * limit 1000 / 24h
     *
     * @param int $tweetId
     */
    public function postFavorite(int $tweetId)
    {
        try {
            $result = $this->twitter->postFavorite(['id' => $tweetId]);
        } catch (RuntimeException $e) {
            logger()->error('いいねに失敗しました:' . $e->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * フォローする
     * limit 1000 / 24h
     *
     * @param int $twitterUserId
     */
    public function postFollow(int $twitterUserId)
    {
        try {
            $result = $this->twitter->postFollow(['user_id' => $twitterUserId]);
        } catch (RuntimeException $e) {
            logger()->error('フォローに失敗しました:' . $e->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * RTする
     * limit 300 / 3h
     *
     * @param int $tweetId
     */
    public function postRetweet($tweetId)
    {
        try {
            $result = $this->twitter->postRt($tweetId);
        } catch (RuntimeException $e) {
            logger()->error('RTに失敗しました:' . $e->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * 対象アカウントのファボを取得
     * limit 75 / 15min
     *
     * @param int $tweetId
     * @param int $count
     */
    public function getFavorites($twitterUserId, int $count)
    {
        try {
            $result = $this->twitter->getFavorites(['id' => $twitterUserId, 'max' => $count, 'include_entities' => 0]);
        } catch (RuntimeException $e) {
            logger()->error('いいねの取得に失敗しました:' . $e->getMessage());
            return false;
        }
        return $result;
    }
}
