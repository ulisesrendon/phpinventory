<?php

namespace Lib\Http;

use Lib\Http\ApiResponse;
use Lib\Http\RequestData;

class DefaultController
{
    public function __construct(public RequestData $Request)
    {
    }
    public function home(array $args = []): bool
    {
        ApiResponse::json('Hello, world!');

        return true;
    }

}