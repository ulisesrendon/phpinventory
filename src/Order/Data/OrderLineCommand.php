<?php

namespace Stradow\Order\Data;

use Stradow\Framework\Database\DataBaseAccess;

class OrderLineCommand
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function create(
        ?int $order,
        ?int $product,
        int $pieces,
        int|float $amountTotal = 0,
        int|float $amountByPiece = 0,
    ): ?int {

        $id = $this->DataBaseAccess->create(
            table: 'orderlines',
            fields: [
                'order_id' => $order,
                'product_id' => $product,
                'pieces' => $pieces,
                'amount_total' => $amountTotal,
                'amount_by_piece' => $amountByPiece,
            ]
        );

        return empty($id) ? null : (int) $id;
    }

    public function update(array $fields): ?bool
    {
        return $this->DataBaseAccess->update('orderlines', $fields);
    }
}
