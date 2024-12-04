<?php

namespace Stradow\User\Data;

use Stradow\Framework\Database\DataBaseAccess;

class UserCommand
{
    private DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function create(
        int|float $amount = 0,
        ?int $customer = null,
        ?int $address = null,
        ?int $paymentMethod = null,
        array $lines = [],
    ): ?int {
        $this->DataBaseAccess->beginTransaction();

        try {
            $orderId = $this->DataBaseAccess->insert(
                table: 'orders',
                fields: [
                    'amount_total' => $amount,
                    'customer_id' => $customer,
                    'address_id' => $address,
                    'payment_method_id' => $paymentMethod,
                ]
            );

            foreach ($lines as $k => $line) {
                $lines[$k]['order_id'] = $orderId;
            }

            $this->DataBaseAccess->multiInsert(
                table: 'orderlines',
                data: $lines,
            );

            $this->DataBaseAccess->commit();
        } catch (\Exception $e) {
            $this->DataBaseAccess->rollback();
            throw $e;
        }

        return empty($orderId) ? null : (int) $orderId;
    }

    public function update(array $fields): ?bool
    {
        $fields['updated_date'] ??= 'now()';

        return $this->DataBaseAccess->update('orders', $fields);
    }
}
