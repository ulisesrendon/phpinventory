<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HyperItemsRenderForImg implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        return "<img src=\"{$context->getValue()}\">";
    }
}