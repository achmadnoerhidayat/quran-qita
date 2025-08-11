<?php

namespace App\Http\Controllers;

class ResponseFormated
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null
        ],
        'data' => null
    ];

    public static function success($data = null, $message = null)
    {
        $response = [
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => $message
            ],
            'data' => $data
        ];

        return response()->json($response, 200);
    }

    public static function error($data = null, $message = null, $error = 404)
    {
        $response = [
            'meta' => [
                'code' => $error,
                'status' => 'error',
                'message' => $message
            ],
            'data' => $data
        ];

        return response()->json($response, $error);
    }
}
