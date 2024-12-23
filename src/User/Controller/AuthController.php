<?php

namespace Stradow\User\Controller;

use Neuralpin\HTTPRouter\RequestData;
use Neuralpin\HTTPRouter\Response;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\User\Data\UserCommand;
use Stradow\User\Data\UserQuery;

class AuthController
{
    // private readonly UserQuery $OrderLineQuery;

    // private readonly UserCommand $OrderCommand;

    // protected readonly DataBaseAccess $DataBaseAccess;

    // public function __construct()
    // {
    //     $this->DataBaseAccess = Container::get(DataBaseAccess::class);
    //     $this->UserQuery = new UserQuery($this->DataBaseAccess);
    //     $this->UserCommand = new UserCommand($this->DataBaseAccess);
    // }

    // public function register(RequestData $Request)
    // {
    //     return Response::json([
    //         'status' => 'si',
    //     ]);
    // }
}
