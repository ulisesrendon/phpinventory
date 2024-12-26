<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class TextBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? 'div',
            attributes: $State->getAttributes(),
            content: array_reduce(
                array: $State->getChildren(),
                callback: fn ($carry, $item) => "{$carry}{$this->renderChildTag($item)}"
            ),
            isEmpty: false,
        );
    }

    public function renderChildTag(NodeStateInterface $Item)
    {
        return (string) new TagRender(
            tag: $Item->getProperty('tag') ?? 'p',
            attributes: $Item->getAttributes(),
            content: (string) $Item,
            isEmpty: false,
        );
    }
}
