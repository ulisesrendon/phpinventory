<?php
namespace Lib\Http;

class RouteController
{
    public function __construct(
        public array|object $Controller, 
        public array $Params
    )
    {
    }
}