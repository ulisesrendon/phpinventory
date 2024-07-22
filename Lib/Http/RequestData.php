<?php
namespace Lib\Http;

class RequestData
{
    public function __construct(
        public array $headers = [],
        public object|array|null $body = [],
        public array $params = [],
        public string $method = 'get',
        public string $uri = '/',
    )
    {

    }
}