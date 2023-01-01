<?php

namespace App\Http\Controllers\Api;


use App\Helper\TokenHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;


class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \App\Http\Resources\TokenResource
     */
    public function token(TokenHelper $helper)
    {
        return new TokenResource($helper->getRegistrationToken());
    }

}
