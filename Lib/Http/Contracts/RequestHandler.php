<?php
namespace Lib\Http\Contracts;

use Stringable;

interface RequestHandler
{
    public function setController(ControllerWrapper $controller);

    public function getResponse(): ResponseState;
    
    // public function getURI(): int;

    // public function getMethod(): string;
}