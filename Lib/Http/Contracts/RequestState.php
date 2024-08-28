<?php
namespace Lib\Http\Contracts;

interface RequestState
{
    public function getHeaders(): array;

    public function getBody(): object|array|null;

    public function getParams(): array;

    public function getMethod(): string;

    public function getPath(): string;
}