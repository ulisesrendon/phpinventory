<?php
namespace App\Order\Interface;

interface OrderLineItemInterface
{
    public function getPieces(): null|int;
    public function getProductId(): null|int;
}