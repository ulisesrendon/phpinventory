<?php
namespace App\Order\Data;

use App\Order\Interface\OrderLineItemInterface;

class OrderLineState implements OrderLineItemInterface
{
    private ?int $pieces;
    private ?int $productId;

    public function __construct(?int $id, ?int $pieces)
    {
        $this->pieces = $pieces;
        $this->productId = $id;
    }

    public function getPieces(): int|null
    {
        return $this->pieces;
    }

    public function getProductId(): int|null
    {
        return $this->productId;
    }
}