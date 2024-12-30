<?php

use Stradow\Content\Event\CollectionContentAdded;
use Stradow\Content\Event\CollectionContentRemoved;
use Stradow\Content\Event\CollectionUpdated;
use Stradow\Content\Event\ContentUpdated;
use Stradow\Framework\Database\Event\CommandExecuted;
use Stradow\Framework\Database\Event\QueryExecuted;
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
    QueryExecuted::class => [
        function(QueryExecuted $Event){
            \Stradow\Framework\Log::append(json_encode([
                'query' => $Event->getquery(),
                'params' => $Event->getParams(),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES));
        }
    ],
    CommandExecuted::class => [
        function (CommandExecuted $Event) {
            \Stradow\Framework\Log::append(json_encode([
                'query' => $Event->getquery(),
                'params' => $Event->getParams(),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES));
        }
    ],
];
