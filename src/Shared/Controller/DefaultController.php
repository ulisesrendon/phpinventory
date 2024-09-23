<?php

namespace App\Shared\Controller;

use App\Shared\Database\DataBaseAccess;
use Neuralpin\HTTPRouter\Response;
use PDO;

class DefaultController
{
    protected readonly DataBaseAccess $DataBaseAccess;

    public function __construct()
    {
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

    public function home()
    {
        return Response::json('Hello, world!');
    }
}
