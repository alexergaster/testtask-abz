<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class IndexController extends BaseController
{
    public function __invoke(): JsonResponse
    {
        $page = Request::input('page', 1);
        $count = Request::input('count', 10);

        $response = $this->service->getUserPagination($page, $count);

        $status = $response['status'];
        unset($response['status']);

        return response()->json($response, $status);
    }
}
