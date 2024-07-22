<?php

namespace Lib\Database;

use Lib\Database\DBAccess;

class DefaultModel
{
    public $DBA;
    public function __construct()
    {
        if (is_null(DBAccess::$connection)){
            DBAccess::connect(
                drive: DB_CONFIG['mainrdb']['drive'],
                host: DB_CONFIG['mainrdb']['host'],
                port: DB_CONFIG['mainrdb']['port'],
                name: DB_CONFIG['mainrdb']['name'],
                user: DB_CONFIG['mainrdb']['user'],
                password: DB_CONFIG['mainrdb']['password'],
            );
        }
        $this->DBA = new DBAccess();
    }
}