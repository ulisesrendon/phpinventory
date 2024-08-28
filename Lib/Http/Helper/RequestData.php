<?php

namespace Lib\Http\Helper;

use Lib\Http\Contracts\RequestState;
use Lib\Http\Helper\RequestParamHelper;

class RequestData implements RequestState
{
    public function __construct(
        protected array $headers = [],
        protected object|array|null $body = [],
        protected array $params = [],
        protected string $method = 'get',
        protected string $path = '/',
    ) {
        $this->method = strtolower($this->method);
    }

    public static function createFromGlobals(): RequestState
    {
        return new self(
            headers: getallheaders(),
            body: json_decode(file_get_contents('php://input'), true),
            params: (new RequestParamHelper($_SERVER['QUERY_STRING'] ?? ''))->Params,
            method: $_SERVER['REQUEST_METHOD'],
            path: strtok($_SERVER['REQUEST_URI'] ?? '/', '?'),
        );
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): object|array|null
    {
        return $this->body;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
