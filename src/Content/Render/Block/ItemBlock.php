<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ItemBlock implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        return $context->getValue();
    }
}

