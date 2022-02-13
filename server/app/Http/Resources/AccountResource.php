<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'screen_name' => $this->screen_name,
            'avatar_path' => $this->avatar_path,
            'created_at' => $this->created_at,
        ];
    }
}
