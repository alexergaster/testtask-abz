<?php

namespace App\Http\Controllers\User;


use App\Http\Requests\User\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request): JsonResponse
    {
        $token = $request->header('Authorization');
        $data = $request->validated();
        $response = $this->service->store($data, $token);

        $status = $response['status'];
        unset($response['status']);

        return response()->json($response, $status);
    }
}
