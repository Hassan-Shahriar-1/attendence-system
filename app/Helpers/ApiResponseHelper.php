<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper
{
    public static function successResponse(mixed $data, bool $pagination = false, string $message = '', $responseCode = 200): JsonResponse
    {
        if ($pagination) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data,
                'meta'  => [
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                    'per_page'  => $data->perPage(),
                    'current_page' => $data->currentPage()
                ]
            ], $responseCode);
        } else {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data
            ], $responseCode);
        }
    }

    /**
     * error response
     */
    public static function errorResponse(string $message, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => []
        ], $code);
    }

    /**
     * Server error log
     *
     * @return JsonResponse
     */
    public static function serverError($e = []): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message'   => 'Something Went Wrong',
            'data' => [],
        ], 500);
    }
}
