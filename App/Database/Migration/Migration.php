<?php

namespace App\Database\Migration;

use Lib\Http\ApiResponse;
use Lib\Database\DBAccess;
use Lib\Database\DefaultModel;
use Lib\Http\DefaultController;

class Migration extends DefaultController
{
    public function start(array $args = []): bool
    {
        if (is_null(DBAccess::$connection)) {
            DBAccess::connect(
                drive: DB_CONFIG['mainrdb']['drive'],
                host: DB_CONFIG['mainrdb']['host'],
                port: DB_CONFIG['mainrdb']['port'],
                name: DB_CONFIG['mainrdb']['name'],
                user: DB_CONFIG['mainrdb']['user'],
                password: DB_CONFIG['mainrdb']['password'],
            );
        }

        $this->migrate();

        ApiResponse::json([
            'data' => 'Migration Complete!'
        ]);

        return true;
    }

    public function migrate()
    {
        (new DefaultModel())->DBA->executeCommand("CREATE TABLE IF NOT EXISTS products(
            id serial4 NOT NULL,
            title varchar(255) NULL,
            description varchar(255) NULL,
            deleted_at timestamp(0) NULL,
            created_at timestamp(0) NULL DEFAULT now(),
            updated_at timestamp(0) NULL DEFAULT now(),
            CONSTRAINT products_pkey PRIMARY KEY (id)
        )");
    }
}