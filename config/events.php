<?php

use App\Order\Event\OrderCreated;
use App\Stock\Event\StockUpdatedListener;

return [
    OrderCreated::class => [
        [StockUpdatedListener::class, 'stockDecreased'],
    ],
];