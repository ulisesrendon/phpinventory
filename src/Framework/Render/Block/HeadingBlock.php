<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class HeadingBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $tag = $Context->getProperties('type');

        return "<$tag>{$Context->getValue()}</$tag>";
    }
}
