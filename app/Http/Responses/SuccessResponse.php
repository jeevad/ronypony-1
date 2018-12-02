<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends BaseResponse
{
    protected $message;
    protected $data;

    public function __construct($message = null, array $data = [])
    {
        $this->message = $message ?: trans('alerts.success');
        $this->data = $data;
    }

    public function toJson()
    {
        $content = ['message' => $this->message];
        if ($this->data) {
            $content += ['data' => $this->data];
        }
        return response()->json($content, JsonResponse::HTTP_OK);
    }
}