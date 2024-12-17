<?php

use Stradow\Content\Event\CollectionContentAdded;
use Stradow\Content\Event\CollectionContentRemoved;
use Stradow\Content\Event\CollectionUpdated;
use Stradow\Content\Event\ContentUpdated;
use Stradow\Order\Event\OrderCreated;
use Stradow\Stock\Event\StockUpdatedListener;

return [
    OrderCreated::class => [
        [StockUpdatedListener::class, 'stockDecreased'],
    ],
    ContentUpdated::class => [
    ],
    CollectionUpdated::class => [
    ],
    CollectionContentAdded::class => [
    ],
    CollectionContentRemoved::class => [
    ],
];
