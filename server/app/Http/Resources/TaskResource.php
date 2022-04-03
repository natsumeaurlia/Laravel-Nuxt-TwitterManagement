<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'keyword' => $this->keyword,
            'start_time_period' => $this->start_time_period,
            'end_time_period' => $this->end_time_period,
            'max_execution' => $this->max_execution,
            'range_min_sleep_time' => $this->range_min_sleep_time,
            'type' => $this->type,
            'is_enable' => $this->is_enable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
