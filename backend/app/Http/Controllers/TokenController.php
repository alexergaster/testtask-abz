<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function index(): JsonResponse
    {
        $token = Str::random(80);

        DB::table('registration_tokens')->insert([
            'token' => $token,
            'expires_at' => now()->addMinutes(40),
        ]);

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
