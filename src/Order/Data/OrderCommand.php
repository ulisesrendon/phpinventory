<?php

namespace App\Order\Data;

use App\Framework\Database\DataBaseAccess;

class OrderCommand
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function create(
        int|float $amount = 0,
        ?int $customer = null,
        ?int $address = null,
        ?int $paymentMethod = null,
    ): ?int
    {
        $id = $this->DataBaseAccess->insert(
            table: 'orders', 
            fields: [
                'amount_total' => $amount,
                'customer_id' => $customer,
                'address_id' => $address,
                'payment_method_id' => $paymentMethod,
            ]
        );

        return empty($id) ? null : (int) $id;
    }

    public function update(array $fields): ?bool
    {
        $fields['updated_date'] ??= 'now()';

        return $this->DataBaseAccess->update('orders', $fields);
    }
}
