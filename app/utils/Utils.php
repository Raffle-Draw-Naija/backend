<?php

namespace App\Utils;


use Illuminate\Http\JsonResponse;

class Utils
{
    public function message($msg = "Success", $data, $code): JsonResponse
    {
        return response()->json(["msg" => $msg, "data" => $data], $code);
    }
}
