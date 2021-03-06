<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->mapInto(AccountResource::class);
    }
}
