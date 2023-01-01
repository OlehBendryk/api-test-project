<?php

namespace App\Http\Resources\Positions;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionsResource extends JsonResource
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
            'success' => true,
            'positions' => $this->resource,

        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}
