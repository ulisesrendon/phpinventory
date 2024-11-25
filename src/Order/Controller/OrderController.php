<?php
namespace App\Order\Controller;

use App\Framework\Validator;
use App\Order\Data\OrderQuery;
use App\Order\Data\OrderState;
use App\Order\Data\OrderCommand;
use App\Product\Data\ProductQuery;
use Neuralpin\HTTPRouter\Response;
use Neuralpin\HTTPRouter\RequestData;
use App\Framework\HTTP\DefaultController;
use App\Product\Presentor\ProductOptionGrouping;
use Neuralpin\HTTPRouter\Interface\ResponseState;

class OrderController extends DefaultController
{
    private readonly OrderQuery $OrderQuery;
    private readonly OrderCommand $OrderCommand;
    private readonly ProductQuery $ProductQuery;

    public function __construct()
    {
        parent::__construct();
        $this->OrderQuery = new OrderQuery($this->DataBaseAccess);
        $this->OrderCommand = new OrderCommand($this->DataBaseAccess);
        $this->ProductQuery = new ProductQuery($this->DataBaseAccess);
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

        $Validator = new Validator();    
        $customerIsValid = is_null($customer) || $Validator
            ->setField($customer)
            ->int()
            ->min(1)
            ->isCorrect();

        if(!$customerIsValid){
            $errors[] = 'Invalid customer';
        }

        $addressIsValid = is_null($address) || $Validator
            ->setField($address)
            ->int()
            ->min(1)
            ->isCorrect();

        if(!$addressIsValid){
            $errors[] = 'Invalid customer address';
        }

        $paymentMethodIsValid = is_null($paymentMethod) || $Validator
            ->setField($paymentMethod)
            ->int()
            ->min(1)
            ->isCorrect();

        if (!$paymentMethodIsValid) {
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

        if (!$itemListIsValid) {
            $errors[] = 'Invalid order items';
        }

        $OrderState = new OrderState();
        $ProductIds = [];
        if(empty($errors)){
            try{
                $OrderState
                    ->setCustomer($customer)
                    ->setAddress($address)
                    ->setPaymentMethod($paymentMethod)
                    ->setItems($items);
            }catch(\Exception|\Throwable){
                $errors[] = 'Invalid order data';
            }

            $ProductIds = array_column($items, 'id');
        }

        if(!empty($errors)){
            return Response::json([
                'status' => 'error',
                'error' => 'invalid order data',
            ], 400);
        }

        $ProductData = $this->ProductQuery->list($ProductIds);
        $ProductList = (new ProductOptionGrouping($ProductData))->get();


        $amount = 0;
        $lines = [];

        //[TODO] Validate product stock before creating order
        //[TODO] Validate item entries
        foreach ($items as $item) {
            if (!isset($ProductList[$item['id']])) {
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

            $ProductList[$item['id']]->selected = &$lines[$item['id']];
        }

        $OrderId = $this->OrderCommand->create(
            amount: $amount,
            customer: $customer,
            address: $address,
            paymentMethod: $paymentMethod,
            lines: $lines,
        );

        return Response::json([
            'status' => 'success',
            'order' => [
                'id' => $OrderId,
                'amount' => $amount,
                'customer' => $customer,
                'address' => $address,
                'items' => $items,
                'paymentMethod' => $paymentMethod,
            ],
            'products' => array_values($ProductList),
        ], 201);
    }

    public function getById(int $id)
    {
        return Response::json($id);
    }
}