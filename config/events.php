<?php

use Stradow\Order\Event\OrderCreated;
use Stradow\Content\Event\ContentUpdated;
use Stradow\Content\Event\CollectionUpdated;
use Stradow\Stock\Event\StockUpdatedListener;
use Stradow\Content\Event\CollectionContentAdded;
use Stradow\Content\Event\CollectionContentRemoved;

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
