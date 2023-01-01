<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable
     */
    public function toArray($request)
    {
        return [
            "success" => true,
            "page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "total_users"=> $this->total(),
            "count" => $this->perPage(),
            "links" => [
                "next_url" => $this->nextPageUrl() ? $this->nextPageUrl() . "&count={$this->perPage()}" : null,
                "prev_url"=> $this->previousPageUrl() ? $this->previousPageUrl() . "&count={$this->perPage()}" : null,
            ],
            "users" => $this->items(),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}
