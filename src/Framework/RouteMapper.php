<?php

namespace App\Framework;

use Neuralpin\HTTPRouter\Route;

class RouteMapper extends Route
{
    public function getControllerAll(): array
    {
        return $this->methods;
    }
}