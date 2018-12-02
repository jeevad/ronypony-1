<?php

namespace App\Http\Responses;

class AuthLoginResponse extends BaseResponse
{

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toJson()
    {
        return response()->json([
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600
        ]);
    }
}