<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function internalServerError(\Exception $exception)
    {
        Log::error('Error to process request: ' . $exception->getMessage());
        abort(response()->json(['message' => 'internal server error'], 500));
    }

    protected function notFound(\Exception $exception)
    {
        Log::error('Error to process request: ' . $exception->getMessage());
        abort(response()->json(['message' => 'entity not found'], 404));
    }
}
