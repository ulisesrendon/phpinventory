<?php

namespace Stradow\Order\Data;

use Stradow\Framework\Database\DataBaseAccess;

class OrderQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getOrderQuery(string $extraParts = ''): string
    {
        return "SELECT 
                orders.id,
                orders.customer_id,
                orders.payment_method_id,
                orders.address_id,
                orders.amount_total,
                orders.created_at,
                orders.updated_at
            from orders
            where deleted_at is null $extraParts";
    }

    public function getById(int $id): ?array
    {
        return $this->DataBaseAccess->query($this->getOrderQuery('and orders.id = :id'), ['id' => $id]);
    }

    public function list(?array $ids = null): ?array
    {
        $idCondition = '';
        $params = [];
        if (! empty($ids)) {
            foreach ($ids as $id) {
                $params["id_$id"] = $id;
            }
            $markers = implode(',:', array_keys($params));
            $idCondition = "and orders.id in (:$markers) ";
        }

        return $this->DataBaseAccess->query($this->getOrderQuery($idCondition.'order by orders.id'));
    }
}
