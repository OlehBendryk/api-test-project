<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotFoundResource;
use App\Http\Resources\Positions\PositionsResource;
use App\Models\Position;

class PositionsController extends Controller
{
    public function index()
    {
        $positions = Position::select(['id', 'name'])->get();

        if ($positions->isEmpty()) {
            return new NotFoundResource('Page not found');
        }

        return new PositionsResource($positions);
    }

}
