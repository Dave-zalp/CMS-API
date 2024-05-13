<?php

namespace App;

use Symfony\Component\HttpFoundation\Response;

trait HttpResponse
{
    //
    protected function success($data, $message=null, $code=200)
    {

    return response()->json([
        'data' => $data,
        'code' => $code,
        'message' => $message
    ]);

    }

    protected function error($message=null, $code=404)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'code' => $code,
        ]);
    }
}
