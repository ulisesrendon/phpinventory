<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class ContainerBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? 'div',
            attributes: $State->getAttributes(),
            content: (string) array_reduce(
                array: $State->getChildren(),
                callback: fn ($carry, $item) => $carry.$item
            ),
            isEmpty: false,
        );
    }
}
