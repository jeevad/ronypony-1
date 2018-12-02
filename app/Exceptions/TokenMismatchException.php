<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class TokenMismatchException extends \Exception
{
    public function render($request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $this->getMessage() ?: trans('alerts.token_mismatch'),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}