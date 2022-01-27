<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    public $fillable = [
        'id',
        'name',
        'screen_name',
        'avatar_path',
        'access_token',
        'access_token_secret',
        'api_key',
        'api_secret_key',
    ];

    protected $hidden = [
        'access_token',
        'access_token_secret',
        'api_key',
        'api_secret_key',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountTransitions(): HasMany
    {
        return $this->hasMany(AccountTransition::class);
    }

    /**
     * 暗号化してトークンを保存.
     * @param string $accessToken
     */
    public function setAccessTokenAttribute(string $accessToken): void
    {
        $this->attributes['access_token'] = encrypt($accessToken);
    }

    /**
     * 復号化してトークン返却.
     * @param string $accessToken
     * @return string
     */
    public function getAccessTokenAttribute($accessToken): string
    {
        return $accessToken ? decrypt($accessToken) : '';
    }

    /**
     * 暗号化してトークンを保存.
     * @param string $accessTokenSecret
     */
    public function setAccessTokenSecretAttribute(string $accessTokenSecret): void
    {
        $this->attributes['access_token_secret'] = encrypt($accessTokenSecret);
    }

    /**
     * 復号化してトークン返却.
     * @param string $accessTokenSecret
     * @return string
     */
    public function getAccessTokenSecretAttribute($accessTokenSecret): string
    {
        return $accessTokenSecret ? decrypt($accessTokenSecret) : '';
    }

    /**
     * 暗号化してapi_keyを保存.
     * @param mixed $apiKey
     */
    public function setApiKeyAttribute($apiKey): void
    {
        $this->attributes['api_key'] = $apiKey ? encrypt($apiKey) : '';
    }

    /**
     * 復号化してapi_key返却.
     * @param mixed $apiKey
     * @return string
     */
    public function getApiKeyAttribute($apiKey): string
    {
        return $apiKey ? decrypt($apiKey) : '';
    }

    /**
     * 暗号化してapi_secret_keyを保存.
     * @param mixed $apiSecretKey
     */
    public function setApiSecretKeyAttribute($apiSecretKey): void
    {
        $this->attributes['api_secret_key'] = $apiSecretKey ? encrypt($apiSecretKey) : '';
    }

    /**
     * 復号化してapi_secret_key返却.
     * @param mixed $apiSecretKey
     * @return string
     */
    public function getApiSecretKeyAttribute($apiSecretKey): string
    {
        return $apiSecretKey ? decrypt($apiSecretKey) : '';
    }
}
