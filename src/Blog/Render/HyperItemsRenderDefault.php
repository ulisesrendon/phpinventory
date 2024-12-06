<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\RendereableInterface;
use Stradow\Blog\Render\Interface\NodeContextInterface;

class HyperItemsRenderDefault implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        return json_encode([
            'value' => htmlspecialchars($context->getValue()),
            'children' => $context->getChildren(),
        ]);
    }
}