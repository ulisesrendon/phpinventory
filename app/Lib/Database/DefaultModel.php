<?php

namespace App\Lib\Database;

use App\Lib\Database\DB;

class DefaultModel
{
    public function __construct()
    {
        if (is_null(DB::$dbh)){
            DB::connect();
        }
    }
}