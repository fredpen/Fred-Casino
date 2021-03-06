<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function sendSuccess($data, $message = "Success")
    {
        $response = [
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public static function notFound($message = "Resources not available")
    {
        $response = [
            'message' => $message,
        ];
        return response()->json($response, 404);
    }

    public static function unAuthorised($message = "Unauthorised")
    {
        $response = [
            'message' => $message,
        ];
        return response()->json($response, 401);
    }

    public static function badRequest($message)
    {
        $response = [
            'message' => $message
        ];
        return response()->json($response, 412);
    }

    public static function serverError($message = "We couldn't perform this operation")
    {
        $response = [
            'message' => $message
        ];
        return response()->json($response, 500);
    }

    public static function invalidData($message = "We couldn't perform this operation")
    {
        $response = [
            'message' => $message
        ];
        return response()->json($response, 422);
    }



}
