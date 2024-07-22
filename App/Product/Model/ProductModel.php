<?php
namespace App\Product\Model;

use Lib\Database\DBAccess;
use Lib\Database\DefaultModel;

class ProductModel extends DefaultModel
{

    public function create(array $data)
    {
        return $this->DBA->executeCommand("INSERT INTO products(
                title,
                description
            ) VALUES(
                :title,
                :description
            )", $data);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DBA->executeCommand("DELETE FROM products WHERE id = '$id'");
    }

    public function get()
    {
        return $this->DBA->fetchQuery('SELECT * FROM products');
    }

    public function getByID(int $id)
    {
        return $this->DBA->fetchFirst("SELECT * FROM products WHERE id = '$id'");
    }
}