<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class PlainCodeBlock implements RendereableInterface
{

    public function render(NodeContextInterface $Context): string
    {
        $value = htmlspecialchars($Context->getValue());
        return "<pre><code>$value</code></pre>";
    }
}