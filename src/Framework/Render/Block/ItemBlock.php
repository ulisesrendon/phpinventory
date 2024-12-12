<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ItemBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        return $Context->getValue();
    }
}
