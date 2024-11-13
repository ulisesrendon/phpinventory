<?php

namespace App\Order\Data;

use App\Framework\Database\DataBaseAccess;

class OrderQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->query('SELECT 
                *
            from orders
            where orders.deleted_at is null
            order by orders.created_at desc
        ');
    }

    
}
