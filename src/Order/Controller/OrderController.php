<?php
namespace App\Order\Controller;

use App\Order\Data\OrderQuery;
use App\Order\Data\OrderCommand;
use App\Product\DAO\ProductQuery;
use Neuralpin\HTTPRouter\Response;
use App\Shared\Controller\DefaultController;
use Neuralpin\HTTPRouter\Helper\RequestData;
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

        // [TODO] Item list validation
        // $itemIds = [];
        // foreach($items as $item){
        // }

        $amount = 0;
        $lines = [];
        $ProductList = [];

        if(
            !empty($items) 
            && is_array($items) 
            && array_reduce($items, fn($carry, $item)=> $carry &= in_array('id', array_keys($item)), true)
        ){
            $ProductData = $this->ProductQuery->list(array_column($items, 'id'));
            $ProductList = (new ProductOptionGrouping($ProductData))->get();

            //[TODO] Validate product stock before creating order
            //[TODO] Validate item entries
            foreach($items as $item){
                if(!isset($ProductList[$item['id']])){
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
}