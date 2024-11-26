<?php

namespace Stradow\Order\Data;

use Stradow\Framework\Database\DataBaseAccess;

class OrderLineQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getLineQuery(string $extraParts = ''): string
    {
        return "SELECT 
                orderlines.id,
                orderlines.order_id,
                orderlines.product_id,
                orderlines.pieces,
                orderlines.amount_by_piece,
                orderlines.amount_total,
                products.code,
                products.title,
                products.description,
                products.price
            from orderlines orderlines
            left join products on products.id = orderlines.product_id
            where $extraParts";
    }

    public function getByOrderId(int $id): ?array
    {
        return $this->DataBaseAccess->query($this->getLineQuery('orderlines.order_id = :id'), ['id' => $id]);
    }
}
