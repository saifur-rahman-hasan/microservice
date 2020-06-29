<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonErrorResponse($exception, $message = null)
    {
        $message = $message ?? "Sorry! we are unable to complete your request.";
        $statusCode = 500;

        return response()->json([
            'message' => $message,
            'errors' => [
                'root' => [ $exception->getMessage() ]
            ]
        ], $statusCode);
    }
}
