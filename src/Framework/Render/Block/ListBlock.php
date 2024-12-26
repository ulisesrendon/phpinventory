<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class ListBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {

        $listType = $State->getProperty('listType');
        $attributes = $State->getAttributes();
        if (is_null($listType)) {
            $attributes['type'] ??= $listType;
        }

        return (string) new TagRender(
            tag: $State->getProperty('type') ?? 'ul',
            attributes: $attributes,
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
            tag: $Item->getProperty('tag') ?? 'li',
            attributes: $Item->getAttributes(),
            content: (string) $Item,
            isEmpty: false,
        );
    }
}
