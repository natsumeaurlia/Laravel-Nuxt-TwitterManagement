<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * traitでモデルイベントをフックする
 * @see https://laravel.com/api/8.x/Illuminate/Database/Eloquent/Model.html#method_bootTraits
 */
trait CreatingUuid
{
    /**
     *  Setup model event hooks
     */
    protected static function bootCreatingUuid()
    {
        static::creating(function (Model $model) {
            $model->uuid = Str::uuid();
        });
    }
}
