<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotFoundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "success" => true,
            "user" => [
                "id" => $this->resource->id,
                "first_name" => $this->resource->first_name,
                "last_name" => $this->resource->last_name,
                "email" => $this->resource->email,
                "phone" => $this->resource->phone,
                "position" => $this->resource->email,
                "position_id" => $this->resource->position_id,
                "photo" => $this->resource->photo,
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(404);
    }
}
