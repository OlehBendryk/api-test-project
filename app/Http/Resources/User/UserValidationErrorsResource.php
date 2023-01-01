<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserValidationErrorsResource extends JsonResource
{
    public static $wrap = null;

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
                    "The user_id must be an integer.",
                ],
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(422);
    }
}
