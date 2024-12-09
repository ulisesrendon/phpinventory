<?php
namespace Stradow\Blog\Render\Block;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class TextBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        $content = array_reduce($context->getChildren(), fn($carry, $item) => $carry . "<p>$item</p>");

        return "<div>$content</div>";
    }
}