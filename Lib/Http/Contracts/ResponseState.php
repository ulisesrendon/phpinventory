<?php
namespace Lib\Http\Contracts;

use Stringable;

interface ResponseState
{
    public function getHeaders(): array;

    public function getBody(): string|Stringable;

    public function getStatus(): int;

}