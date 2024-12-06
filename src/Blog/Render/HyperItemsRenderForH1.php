<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HyperItemsRenderForH1 implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        return "<h1>{$context->getValue()}</h1>";
    }
}