<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ContainerBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        $content = array_reduce($context->getChildren(), fn($carry, $item)=> $carry.$item);
        return "<div>$content</div>";
    }

}