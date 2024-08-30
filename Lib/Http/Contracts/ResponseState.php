<?php
namespace Lib\Http\Contracts;

use Stringable;

interface ResponseState
{
    public function getHeaders(): array;

    public function getBody(): string|Stringable;

    public function getStatus(): int;

    public function setParams(array $params);

    public function setMethod(string $method);

    public function setPath(string $path);

}