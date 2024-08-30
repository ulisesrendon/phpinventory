<?php

namespace Lib\Http\Helper;

use Lib\Http\Interface\RequestState;

class RequestData implements RequestState
{
    public function __construct(
        protected array $headers = [],
        protected object|array|null $body = [],
        protected string $method = 'get',
        protected string $path = '/',
        protected array $queryParams = [],
    ) {
        $this->method = strtolower($this->method);
    }

    public static function createFromGlobals(): RequestState
    {
        return new self(
            headers: getallheaders(),
            body: json_decode(file_get_contents('php://input'), true),
            queryParams: (new RequestParamHelper($_SERVER['QUERY_STRING'] ?? ''))->Params,
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

    public function getInput(string $name)
    {
        return $this->body[$name] ?? null;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
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
