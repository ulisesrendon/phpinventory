<?php

use Stradow\Order\Event\OrderCreated;
use Stradow\Stock\Event\StockUpdatedListener;

return [
    OrderCreated::class => [
        [StockUpdatedListener::class, 'stockDecreased'],
    ],
];
