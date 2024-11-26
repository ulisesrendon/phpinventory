<?php

namespace Stradow\Order\Data;

use Stradow\Order\Interface\OrderLineItemInterface;

class OrderLineState implements OrderLineItemInterface
{
    private ?int $pieces;

    private ?int $productId;

    public function __construct(?int $id, ?int $pieces)
    {
        $this->pieces = $pieces;
        $this->productId = $id;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }
}
