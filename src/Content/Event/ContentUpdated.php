<?php
namespace Stradow\Content\Event;

class ContentUpdated
{
    public array $Data;

    public function __construct(array $Data)
    {
        $this->Data = $Data;
    }
}