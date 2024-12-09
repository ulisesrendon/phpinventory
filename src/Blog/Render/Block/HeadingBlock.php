<?php
namespace Stradow\Blog\Render\Block;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HeadingBlock implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        $tag = $context->getProperties()['type'];

        return "<$tag>{$context->getValue()}</$tag>";
    }
}