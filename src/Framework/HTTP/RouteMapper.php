<?php

namespace App\Framework\HTTP;

use Neuralpin\HTTPRouter\Route;

class RouteMapper extends Route
{
    public function getControllerAll(): array
    {
        return $this->methods;
    }
}