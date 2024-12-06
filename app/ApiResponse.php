<?php

namespace App;

use App\Helpers\HttpStatusCode;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function ResponseSuccess($data = [], $message = "Success"): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], HttpStatusCode::SUCCESS);
    }

    public function ResponseError($message = "Error", $statusCode = HttpStatusCode::BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ],$statusCode);
    }

    public function ResponseSuccessWithPaginate($data, $message = "Success", $pagination = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $pagination
        ],200);
    }
}
