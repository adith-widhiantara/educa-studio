<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class Response
{
    /**
     * @param $message
     * @param $data
     *
     * @return JsonResponse
     */
    public static function success($message, $data): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ]);
    }
}