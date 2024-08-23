<?php

namespace App\Shared\Controller;

use PDO;
use Lib\Http\Router;
use Lib\Http\Response;
use Lib\Database\DataBaseAccess;
use Lib\Http\Helper\RequestData;

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
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->DataBaseAccess = new DataBaseAccess($PDO);
    }

    public function home(array $args = [])
    {
        return Response::json('Hello, world!');
    }
}
