<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class UnauthorizedResponse extends BaseResponse
{
    protected $message;

    public function __construct($message = null)
    {
        $this->message = $message ?? trans('alerts.unauthorized');
    }

    public function toJson()
    {
        return response()->json([
            'message' => $this->message
        ], JsonResponse::HTTP_FORBIDDEN);
    }
}