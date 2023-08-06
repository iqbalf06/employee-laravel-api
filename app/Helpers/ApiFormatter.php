<?php

namespace App\Helpers;

class ApiFormatter
{
    public static function createApi($code = null, $message = null, $data = null)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
