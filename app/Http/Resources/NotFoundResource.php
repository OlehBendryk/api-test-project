<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotFoundResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "success" => false,
            "message" => $this->resource,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(404);
    }
}
