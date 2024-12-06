<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HyperItemsRenderForPlainCode implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        $value = htmlspecialchars($context->getValue());
        return "<pre><code>$value</code></pre>";
    }
}