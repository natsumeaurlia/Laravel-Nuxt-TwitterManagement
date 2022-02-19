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
    public function __invoke(User $user, string $token, string $tokenSecret, string $consumer, string $consumerSecret)
    {
        $twitter = TwitterApiService::createWithCredentials($token, $tokenSecret, $consumer, $consumerSecret);
        $twitterUser = $twitter->getCredentials();
        if (!$twitterUser) {
            throw new MissingCredentialException('missing credential.', 403);
        };

        return $user->accounts()->updateOrCreate(['id' => $twitterUser->id], [
            'name' => $twitterUser->name,
            'screen_name' => $twitterUser->screen_name,
            'avatar_path' => $twitterUser->profile_image_url,
            'access_token' => $token,
            'access_token_secret' => $tokenSecret,
            'api_key' => $consumer,
            'api_secret_key' => $consumerSecret
        ]);
    }
}
