<?php

namespace Stradow\Database;

use Stradow\Framework\Log;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

require __DIR__.'/../../bootstrap/app.php';

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

            file_put_contents('php://output', 'Migration Complete!'.PHP_EOL);
        } catch (\Exception $e) {
            Log::append(json_encode($e, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
            file_put_contents('php://output', 'Migration Failed! - Data may be corrupt'.PHP_EOL);
        }

    }
}
