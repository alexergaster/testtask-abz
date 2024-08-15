<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function index(): JsonResponse
    {
        $positions = Position::all();

        if (empty($positions)) {
            return response()->json(["success" => false, "message" => "Positions not found"], 404);
        }

        return response()->json($positions);
    }
}
