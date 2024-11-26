<?php

namespace Stradow\Order\Interface;

interface OrderLineItemInterface
{
    public function getPieces(): ?int;

    public function getProductId(): ?int;
}
