<?php

namespace Stradow\Content\Event;

class CollectionUpdated
{
    public array $Data;

    public function __construct(array $Data)
    {
        $this->Data = $Data;
    }
}
