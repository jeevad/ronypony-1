<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class BadResponse extends BaseResponse
{
    protected $message;
    protected $data;

    public function __construct($message = null, array $data = [])
    {
        $this->message = $message ?? trans('alerts.bad_request');
        $this->data = $data;
    }

    public function toJson()
    {
        $content = ['message' => $this->message];
        if ($this->data) {
            $content += ['data' => $this->data];
        }
        return response()->json($content, JsonResponse::HTTP_BAD_REQUEST);
    }
}