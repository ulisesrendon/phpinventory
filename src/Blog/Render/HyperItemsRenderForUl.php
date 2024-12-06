<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HyperItemsRenderForUl implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        $content = array_reduce($context->getChildren(), fn($carry, $item) => $carry . "<li>$item</li>");

        return "<ul>$content</ul>";
    }
}