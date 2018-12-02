<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class UnauthenticatedResponse extends BaseResponse
{
    protected $message;

    public function __construct($message = null)
    {
        $this->message = $message ?? trans('alerts.unauthenticated');
    }

    public function toJson()
    {
        return response()->json([
            'message' => $this->message
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }
}