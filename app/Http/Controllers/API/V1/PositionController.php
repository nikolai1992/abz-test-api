<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionIndexResource;
use App\Models\Position;

class PositionController extends Controller
{
	public function index()
	{
        $positions = Position::all();

        return response()->json([
            'success' => true,
            'positions' => PositionIndexResource::collection($positions)
        ]);
	}
}
