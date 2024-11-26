<?php

namespace Stradow\Stock\Event;

use Stradow\Framework\Log;

class StockUpdatedListener
{
    public static function stockDecreased(object $Event)
    {
        Log::append(json_encode($Event->Data));
    }
}
