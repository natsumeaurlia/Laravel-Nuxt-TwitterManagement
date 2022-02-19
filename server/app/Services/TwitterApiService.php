<?php

namespace App\Services;

use App\Entities\Twitter\Tweet;
use App\Entities\Twitter\User;
use Atymic\Twitter\ApiV1\Service\Twitter;
use Illuminate\Support\Collection;
use RuntimeException;

class TwitterApiService
{
    public const SEARCH_RESULT_TYPE = ['popular', 'recent', 'mixed'];
    private const SEARCH_DEFAULT_RESULT_TYPE = 'mixed';

    private Twitter $twitter;

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * ユーザーの取得
     * limit 900 / 15min
     *
     * @param string $screenName
     * @return User
     */
    public function getUser(string $screenName): ?User
    {
        try {
            $screenName = str_replace('@', '', $screenName);
            $user = $this->twitter->getUsers(['screen_name' => $screenName]);
        } catch (RuntimeException $e) {
            return null;
        }
        return new User($user);
    }

    /**
     * キーワードからツイートの検索
     * limit 180 / 15min
     *
     * @param string $keyword
     * @param int $count
     * @param string $result_type
     * @return Collection
     */
    public function getTweets(string $keyword, int $count = 5, string $result_type = ''): Collection
    {
        if (!in_array($result_type, self::SEARCH_RESULT_TYPE)) {
            $result_type = self::SEARCH_DEFAULT_RESULT_TYPE;
        }
        try {
            $result = $this->twitter->getSearch(['q' => $keyword, 'count' => $count, 'popular' => $result_type]);
            $tweets = collect($result->statuses)->transform(fn($i) => new Tweet($i));
        } catch (RuntimeException $e) {
            logger()->error('Tweetの取得に失敗しました:' . $e->getMessage());
            return collect();
        }
        return $tweets;
    }

    /**
     * いいねする
     * limit 1000 / 24h
     *
     * @param int $tweetId
     * @return bool;
     */
    public function postFavorite(int $tweetId): bool
    {
        try {
            $result = $this->twitter->postFavorite(['id' => $tweetId]);
        } catch (RuntimeException $e) {
            logger()->error('いいねに失敗しました:' . $e->getMessage());
            return false;
        }
        return (bool)$result;
    }

    /**
     * フォローする
     * limit 1000 / 24h
     *
     * @param int $twitterUserId
     * @return bool
     */
    public function postFollow(int $twitterUserId): bool
    {
        try {
            $result = $this->twitter->postFollow(['user_id' => $twitterUserId]);
        } catch (RuntimeException $e) {
            logger()->error('フォローに失敗しました:' . $e->getMessage());
            return false;
        }
        return (bool)$result;
    }

    /**
     * RTする
     * limit 300 / 3h
     *
     * @param int $tweetId
     * @return bool
     */
    public function postRetweet(int $tweetId): bool
    {
        try {
            $result = $this->twitter->postRt($tweetId);
        } catch (RuntimeException $e) {
            logger()->error('RTに失敗しました:' . $e->getMessage());
            return false;
        }
        return (bool)$result;
    }

    public function usingCredentials(
        string  $accessToken,
        string  $accessTokenSecret,
        ?string $consumerKey = null,
        ?string $consumerSecret = null
    ): TwitterApiService
    {
        $changedApi = $this->twitter->usingCredentials($accessToken, $accessTokenSecret, $consumerKey, $consumerSecret);
        return new self($changedApi);
    }

    public function getCredentials(): ?User
    {
        $credentials = $this->twitter->getCredentials();
        if (is_object($credentials) && !isset($credentials->error)) {
            return new User($credentials);
        }
        return null;
    }

    public static function createWithCredentials(
        string  $accessToken,
        string  $accessTokenSecret,
        ?string $consumerKey = null,
        ?string $consumerSecret = null
    ): TwitterApiService
    {
        $api = app()->make(TwitterApiService::class);
        return $api->usingCredentials($accessToken, $accessTokenSecret, $consumerKey, $consumerSecret);
    }
}
