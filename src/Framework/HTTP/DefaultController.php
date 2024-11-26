<?php

namespace Stradow\Framework\HTTP;

use Neuralpin\HTTPRouter\Response;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

class DefaultController
{
    protected readonly DataBaseAccess $DataBaseAccess;

    public function __construct()
    {
        $this->DataBaseAccess = Container::get(DataBaseAccess::class);
    }

    public function home()
    {
        return Response::json('Hello, world!');
    }
}
