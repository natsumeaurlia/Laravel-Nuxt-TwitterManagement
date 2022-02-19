<?php

namespace App\UseCases\Account;

use App\Models\User;
use App\Services\TwitterApiService;
use App\UseCases\Account\Exception\MissingCredentialException;

class StoreWithCredentials
{
    /**
     * @return User|\Illuminate\Database\Eloquent\Model
     * @throws MissingCredentialException
     */
    public function __invoke(User $user, string $accessToken, string $accessTokenSecret, string $consumerKey, string $consumerSecret)
    {
        $twitter = TwitterApiService::createWithCredentials($accessToken, $accessTokenSecret, $consumerKey, $consumerSecret);
        $twitterUser = $twitter->getCredentials();
        if (!$twitterUser) {
            throw new MissingCredentialException('missing credential.', 403);
        };

        return $user->accounts()->updateOrCreate(
            ['id' => $twitterUser->id],
            [
                'name' => $twitterUser->name,
                'screen_name' => $twitterUser->screen_name,
                'avatar_path' => $twitterUser->profile_image_url,
                'access_token' => $accessToken,
                'access_token_secret' => $accessTokenSecret,
                'api_key' => $consumerKey,
                'api_secret_key' => $consumerSecret
            ]);

    }
}
