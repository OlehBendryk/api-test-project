<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersValidationErrorsResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            "success" => false,
            "message" => "Validation failed",
            "fails" => $this->messages(),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(422);
    }
}
