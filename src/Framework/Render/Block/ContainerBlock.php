<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ContainerBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $content = array_reduce($State->getChildren(), fn ($carry, $item) => $carry.$item);

        $tag = $State->getProperty('tag') ?? 'div';

        return "<$tag>$content</$tag>";
    }
}
