<?php

namespace Lib\Http\Helper;

use Lib\Http\Helper\RequestParamHelper;

class RequestData
{
    public function __construct(
        public array $headers = [],
        public object|array|null $body = [],
        public array $params = [],
        public string $method = 'get',
        public string $uri = '/',
    ) {
        $this->method = strtolower($this->method);
    }

    public static function createFromGlobals(): RequestData
    {
        return new self(
            headers: getallheaders(),
            body: json_decode(file_get_contents('php://input'), true),
            params: (new RequestParamHelper($_SERVER['QUERY_STRING'] ?? ''))->Params,
            method: $_SERVER['REQUEST_METHOD'],
            uri: strtok($_SERVER['REQUEST_URI'] ?? '/', '?'),
        );
    }
}
