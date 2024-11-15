<?php
namespace App\Order\Data;

use App\Order\Data\OrderLineState;
use App\Order\Interface\OrderLineItemInterface;

class OrderState
{
    protected ?int $customer;
    protected ?int $address;
    protected ?int $paymentMethod;

    /**
     * Summary of items
     * @var OrderLineItemInterface[]
     */
    protected array $items = [];

    public function setCustomer(?int $customer): static
    {
        $this->customer = $customer;
        return $this;
    }

    public function setAddress(?int $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function setPaymentMethod(?int $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function setItems(array $items): static
    {
        foreach($items as $item){
            $this->addItem(new OrderLineState(
                id: $item['id'],
                pieces: $item['pieces'],
            ));
        }

        return $this;
    }

    public function addItem(OrderLineItemInterface $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    public function getCustomer(): int|null
    {
        return $this->customer;
    }

    public function getAddress(): int|null
    {
        return $this->address;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    /**
     * Summary of getItems
     * @return OrderLineItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}