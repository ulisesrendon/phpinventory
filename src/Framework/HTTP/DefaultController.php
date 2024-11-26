<?php

namespace App\Framework\HTTP;

use PDO;
use Neuralpin\HTTPRouter\Response;
use App\Framework\Database\DataBaseAccess;
use App\Framework\DependencyResolver\Container;

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
