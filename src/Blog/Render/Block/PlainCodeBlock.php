<?php
namespace Stradow\Blog\Render\Block;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class PlainCodeBlock implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        $value = htmlspecialchars($context->getValue());
        return "<pre><code>$value</code></pre>";
    }
}