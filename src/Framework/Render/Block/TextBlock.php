<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class TextBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $content = array_reduce($Context->getChildren(), fn ($carry, $item) => "$carry<p>$item</p>");

        return "<div>$content</div>";
    }
}
