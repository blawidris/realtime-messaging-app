<?php

namespace App\Traits;


trait Helper
{

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function responseJson($status = true, $data = [], $message = '', $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }
}
