<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class PlainCodeBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $value = htmlspecialchars($Context->getValue());

        return "<pre><code>$value</code></pre>";
    }
}
