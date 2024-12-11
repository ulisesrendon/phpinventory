<?php

namespace Stradow\Database;

use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../bootstrap/environment.php';
define('DB_CONFIG', require __DIR__.'/../../config/database.php');
require __DIR__.'/../../bootstrap/databaseAccess.php';

class Migrate
{
    public static function start()
    {
        $DataBaseAccess = Container::get(DataBaseAccess::class);

        try {

            require __DIR__.'/Migrations/0_Authentication.php';
            require __DIR__.'/Migrations/1_Products.php';
            require __DIR__.'/Migrations/2_Entries.php';
            require __DIR__.'/Migrations/3_Orders.php';
            require __DIR__.'/Migrations/4_Content.php';

            file_put_contents('php://output', 'Migration Complete!');
        } catch (\Exception $e) {
            file_put_contents('php://output', 'Migration Failed! - Data may be corrupt');
        }

    }
}
