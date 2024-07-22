<?php

namespace App\Database\Migration;

use App\Lib\Database\DB;
use App\Lib\Http\ApiResponse;
use App\Lib\Http\DefaultController;

class Migration extends DefaultController
{
    public function start(array $args = []): bool
    {
        if (is_null(DB::$dbh)) {
            DB::connect();
        }

        $this->migrate();

        ApiResponse::json([
            'data' => 'Migration Complete!'
        ]);

        return true;
    }

    public function migrate()
    {
        DB::executeCommand("CREATE TABLE IF NOT EXISTS products(
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