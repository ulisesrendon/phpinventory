<?php

namespace Lib\Http;

use Lib\Database\DataBaseAccess;
use PDO;

class DefaultController
{
    protected readonly RequestData $Request;

    protected readonly DataBaseAccess $DataBaseAccess;

    public function __construct()
    {
        $this->Request = Router::$RequestData;

        $drive = DB_CONFIG['mainrdb']['drive'];
        $host = DB_CONFIG['mainrdb']['host'];
        $port = DB_CONFIG['mainrdb']['port'];
        $name = DB_CONFIG['mainrdb']['name'];
        $user = DB_CONFIG['mainrdb']['user'];
        $password = DB_CONFIG['mainrdb']['password'];

        $PDO = new PDO(
            "$drive:host=$host;port=$port;dbname=$name",
            $user,
            $password
        );
        $this->DataBaseAccess = new DataBaseAccess($PDO);
    }

    public function home(array $args = [])
    {
        return Response::json('Hello, world!');
    }
}
