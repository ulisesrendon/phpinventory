<?php

namespace App\Lib\Http;

use App\Lib\Http\ApiResponse;

class DefaultController
{
    public function __construct(public RequestData $Request){

    }
    public function home(array $args = []): bool
    {
        ApiResponse::json([
            'data' => 'Hello, world!'
        ]);

        return true;
    }

}