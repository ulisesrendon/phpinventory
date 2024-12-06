<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HyperItemsRenderForItem implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        return $context->getValue();
    }
}

