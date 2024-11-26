<?php
namespace Stradow\Order\Controller;

use Stradow\Framework\Validator;

class OrderInputValidation
{
    public Validator $Validator;

    public array $errors = [];

    public function __construct(
        ?int $customer,
        ?int $address,
        ?int $paymentMethod,
        array $items = [],
    )
    {
        $this->errors = [];

        $this->Validator = new Validator;

        if (!$this->customerIsValid($customer)) {
            $this->errors[] = 'Invalid customer';
        }

        if (!$this->addressIsValid($address)) {
            $this->errors[] = 'Invalid customer address';
        }

        if (!$this->paymentMethodIsValid($paymentMethod)) {
            $this->errors[] = 'Invalid payment method';
        }

        if (!$this->itemListIsValid($items)) {
            $this->errors[] = 'Invalid order items';
        }
    }

    public function customerIsValid(?int $customer): bool
    {
        return is_null($customer) || $this->Validator
            ->setField($customer)
            ->int()
            ->min(1)
            ->isCorrect();
    }

    public function addressIsValid(?int $address): bool
    {
        return is_null($address) || $this->Validator
            ->setField($address)
            ->int()
            ->min(1)
            ->isCorrect();
    }

    public function paymentMethodIsValid(?int $paymentMethod): bool
    {
        return is_null($paymentMethod) || $this->Validator
            ->setField($paymentMethod)
            ->int()
            ->min(1)
            ->isCorrect();
    }

    public function productIdIsValid($item): bool
    {
        return $this->Validator
            ->setField($item)
            ->required()
            ->int()
            ->min(1)
            ->isCorrect();
    }

    public function productPiecesIsValid($item): bool
    {
        return $this->Validator
            ->setField($item)
            ->required()
            ->int()
            ->min(0)
            ->isCorrect();
    }

    public function itemListIsValid($items)
    {
        return is_array($items) && array_reduce(
            array: $items,
            callback: function ($carry, $item): bool {
                $productIdExists = isset($item['id']);

                $productIdIsValid = $productIdExists && $this->productIdIsValid($item['id']);

                $productPiecesExists = isset($item['pieces']);

                $productPiecesIsValid = $productPiecesExists && $this->productPiecesIsValid($item['pieces']);

                return $carry &= $productIdIsValid && $productPiecesIsValid;
            },
            initial: true
        );
    }
}