<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ServerErrorResponse extends BaseResponse
{
    protected $message;

    public function __construct($message = null)
    {
        $this->message = $message ?? trans('alerts.something_went_wrong');
    }

    public function toJson()
    {
        return response()->json(['message' => $this->message], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}