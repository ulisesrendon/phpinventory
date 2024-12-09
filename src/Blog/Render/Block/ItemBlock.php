<?php
namespace Stradow\Blog\Render\Block;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class ItemBlock implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        return $context->getValue();
    }
}

