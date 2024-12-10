<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class HeadingBlock implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        $tag = $context->getProperties()['type'];

        return "<$tag>{$context->getValue()}</$tag>";
    }
}