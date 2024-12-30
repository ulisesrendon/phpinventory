<?php

namespace Stradow\Order\Controller;

use Stradow\Framework\Validator;
use Neuralpin\HTTPRouter\Response;
use Stradow\Framework\Event\Event;
use Stradow\Order\Data\OrderQuery;
use Stradow\Order\Data\OrderState;
use Stradow\Order\Data\OrderCommand;
use Neuralpin\HTTPRouter\RequestData;
use Stradow\Order\Event\OrderCreated;
use Stradow\Order\Data\OrderLineQuery;
use Stradow\Product\Data\ProductQuery;
use Stradow\Framework\HTTP\DefaultController;
use Neuralpin\HTTPRouter\Interface\ResponseState;
use Stradow\Framework\DependencyResolver\Container;

class OrderController extends DefaultController
{
    private readonly OrderQuery $OrderQuery;

    private readonly OrderCommand $OrderCommand;

    private readonly OrderLineQuery $OrderLineQuery;

    private readonly ProductQuery $ProductQuery;

    private Event $EventDispatcher;

    public function __construct()
    {
        parent::__construct();
        $this->OrderQuery = new OrderQuery($this->DataBaseAccess);
        $this->OrderCommand = new OrderCommand($this->DataBaseAccess);
        $this->ProductQuery = new ProductQuery($this->DataBaseAccess);
        $this->OrderLineQuery = new OrderLineQuery($this->DataBaseAccess);
        $this->EventDispatcher = Container::get(Event::class);
    }

    public function list(): ResponseState
    {
        $Orders = $this->OrderQuery->list();

        return Response::json([
            'count' => count($Orders),
            'list' => $Orders,
        ]);
    }

    public function create(RequestData $Request): ResponseState
    {
        $customer = $Request->getInput('customer');
        $address = $Request->getInput('address');
        $paymentMethod = $Request->getInput('paymentMethod');
        $items = $Request->getInput('items') ?? [];

        $errors = [];

        $Validator = new Validator;
        $customerIsValid = is_null($customer) || $Validator
            ->setField($customer)
            ->int()
            ->min(1)
            ->isCorrect();

        if (! $customerIsValid) {
            $errors[] = 'Invalid customer';
        }

        $addressIsValid = is_null($address) || $Validator
            ->setField($address)
            ->int()
            ->min(1)
            ->isCorrect();

        if (! $addressIsValid) {
            $errors[] = 'Invalid customer address';
        }

        $paymentMethodIsValid = is_null($paymentMethod) || $Validator
            ->setField($paymentMethod)
            ->int()
            ->min(1)
            ->isCorrect();

        if (! $paymentMethodIsValid) {
            $errors[] = 'Invalid payment method';
        }

        $itemListIsValid = is_array($items) && array_reduce(
            array: $items,
            callback: function ($carry, $item) use ($Validator): bool {
                $productIdExists = isset($item['id']);

                $productIdIsValid = $productIdExists && $Validator
                    ->setField($item['id'])
                    ->required()
                    ->int()
                    ->min(1)
                    ->isCorrect();

                $productPiecesExists = isset($item['pieces']);

                $productPiecesIsValid = $productPiecesExists && $Validator
                    ->setField($item['pieces'])
                    ->required()
                    ->int()
                    ->min(0)
                    ->isCorrect();

                return $carry &= $productIdIsValid && $productPiecesIsValid;
            },
            initial: true
        );

        if (! $itemListIsValid) {
            $errors[] = 'Invalid order items';
        }

        $OrderState = new OrderState;
        $ProductIds = [];
        if (empty($errors)) {
            try {
                $OrderState
                    ->setCustomer($customer)
                    ->setAddress($address)
                    ->setPaymentMethod($paymentMethod)
                    ->setItems($items);
            } catch (\Exception|\Throwable) {
                $errors[] = 'Invalid order data';
            }

            $ProductIds = array_column($items, 'id');
        }

        if (! empty($errors)) {
            return Response::json([
                'status' => 'error',
                'error' => 'invalid order data',
            ], 400);
        }

        $ProductData = $this->ProductQuery->list($ProductIds);

        $ProductList = [];
        foreach ($ProductData as $row) {
            $ProductList[$row->id] = $row;
        }

        $amount = 0;
        $lines = [];

        foreach ($items as $item) {
            if (! isset($ProductList[$item['id']])) {
                continue;
            }

            $total = $ProductList[$item['id']]->price * $item['pieces'];
            $amount += $total;

            $lines[$item['id']] = [
                'product_id' => $item['id'],
                'pieces' => $item['pieces'],
                'amount_by_piece' => $ProductList[$item['id']]->price,
                'amount_total' => $total,
            ];
        }

        $OrderId = $this->OrderCommand->create(
            amount: $amount,
            customer: $customer,
            address: $address,
            paymentMethod: $paymentMethod,
            lines: $lines,
        );

        $OrderData = [
            'id' => $OrderId,
            'amount' => $amount,
            'customer' => $customer,
            'address' => $address,
            'items' => $items,
            'paymentMethod' => $paymentMethod,
        ];

        $this->EventDispatcher->dispatch(new OrderCreated($OrderData));

        return Response::json($OrderData, 201);
    }

    public function getById(int $id)
    {
        $Data = $this->OrderQuery->getById($id);

        if (is_null($Data)) {
            return Response::json([
                'id' => $id,
                'order' => [],
            ], 404);
        }

        return Response::json([
            'id' => $id,
            'order' => $Data[0],
            'products' => $this->OrderLineQuery->getByOrderId($id),
        ]);
    }
}
