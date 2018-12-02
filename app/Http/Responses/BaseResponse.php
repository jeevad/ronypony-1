<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

abstract class BaseResponse implements Responsable
{
    public function toResponse($request)
    {
        $format = ucfirst($request->format());
        $method = "to{$format}";

        return $this->{$method}();
    }

    public function __call($method, $parameters)
    {
        return response()->json([
            'message' => trans('alerts.invalid_request_format')
        ], Response::HTTP_NOT_ACCEPTABLE);
    }

    abstract function toJson();
}