<?php

namespace Lib\Http;

use Lib\Http\Response;
use Lib\Http\RequestData;
use Lib\Database\DataBaseAccess;
use Lib\Database\PDOContainer;

class DefaultController
{
    protected readonly DataBaseAccess $DataBaseAccess;
    public function __construct(public RequestData $Request)
    {
        $DataBaseObjectContainer = new PDOContainer(
            drive: DB_CONFIG['mainrdb']['drive'],
            host: DB_CONFIG['mainrdb']['host'],
            port: DB_CONFIG['mainrdb']['port'],
            name: DB_CONFIG['mainrdb']['name'],
            user: DB_CONFIG['mainrdb']['user'],
            password: DB_CONFIG['mainrdb']['password'],
        );
        $this->DataBaseAccess = new DataBaseAccess($DataBaseObjectContainer->get());
    }
    public function home(array $args = []): bool
    {
        Response::json('Hello, world!');

        return true;
    }

}