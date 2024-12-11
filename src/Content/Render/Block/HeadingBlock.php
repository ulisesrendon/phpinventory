<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class HeadingBlock implements RendereableInterface
{

    public function render(NodeContextInterface $Context): string
    {
        $tag = $Context->getProperties()['type'];

        return "<$tag>{$Context->getValue()}</$tag>";
    }
}