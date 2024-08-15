<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\JsonResponse;

class ShowController extends BaseController
{
    public function __invoke($id): JsonResponse
    {
        $response = $this->service->getUserById($id);

        $status = $response['status'];
        unset($response['status']);

        return response()->json($response, $status);
    }
}
