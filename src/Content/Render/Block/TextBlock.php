<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class TextBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $content = array_reduce($Context->getChildren(), fn($carry, $item) => $carry . "<p>$item</p>");

        return "<div>$content</div>";
    }
}