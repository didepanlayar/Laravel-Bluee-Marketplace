<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function jsonResponse($success, $message, $data, $statusCode): jsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
