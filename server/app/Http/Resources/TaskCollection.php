<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->mapInto(TaskResource::class);
    }
}
