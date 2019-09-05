<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse(array $data)
    {
        return response()->json($data, 200);
    }

    protected  function errorResponse($messages, $code)
    {
        return response()->json(['error' => $messages], $code);
    }
}