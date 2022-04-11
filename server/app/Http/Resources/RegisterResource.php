<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class RegisterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(Response::HTTP_CREATED);
    }
}
