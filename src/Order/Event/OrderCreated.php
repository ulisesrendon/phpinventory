<?php

namespace Stradow\Order\Event;

class OrderCreated
{
    public bool $PropagationStopped = false;

    public array $Data;

    public function __construct($Data)
    {
        $this->Data = $Data;
    }
}
