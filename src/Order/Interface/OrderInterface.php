<?php

namespace Stradow\Order\Interface;

interface OrderInterface
{
    public function getCustomer(): ?int;

    public function getAddress(): ?int;

    public function getPaymentMethod(): ?int;

    public function getLines(): array;
}
