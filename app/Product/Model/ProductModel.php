<?php
namespace App\Product\Model;

use App\Lib\Database\DB;
use App\Lib\Database\DefaultModel;

class ProductModel extends DefaultModel
{
    public function create(array $data)
    {
        return DB::executeCommand("INSERT INTO products(
                title,
                description
            ) VALUES(
                :title,
                :description
            )", $data);
    }

    public function deleteByID(int $id): bool
    {
        return DB::executeCommand("DELETE FROM products WHERE id = '$id'");
    }

    public function get()
    {
        return DB::fetchQuery('SELECT * FROM products');
    }

    public function getByID(int $id)
    {
        return DB::fetchFirst("SELECT * FROM products WHERE id = '$id'");
    }
}