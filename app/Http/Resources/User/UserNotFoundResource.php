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
            "success" => false,
            "message" => $this->resource,
            "fails" => [
                "user_id" => [
                    "User not found",
                ],
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(404);
    }
}
