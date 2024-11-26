<?php

namespace App\Stock\Event;

use App\Framework\Log;

class StockUpdatedListener
{
    public static function stockDecreased(object $Event)
    {
        Log::append(json_encode($Event->Data));
    }
}