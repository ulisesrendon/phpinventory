<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class ListBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {

        $listType = $State->getProperty('listType');
        $attributes = $State->getAttributes();
        if (is_null($listType)) {
            $attributes['type'] ??= $listType;
        }

        if ($State->isTemplated()) {
            return (string) new TemplateRender(CONTENT_DIR."/{$State->getProperty('template')}", [
                'BlockState' => $State,
                'GlobalState' => $GlobalState,
                'Config' => $GlobalState->getConfig(),
                'TagRender' => TagRender::class,
                'TemplateRender' => TemplateRender::class,
            ]);
        }

        return (string) new TagRender(
            tag: $State->getProperty('type') ?? 'ul',
            attributes: $attributes,
            content: (string) array_reduce(
                array: $State->getChildren(),
                callback: fn ($carry, $item) => $carry.$this->renderChildTag($item)
            ),
            isEmpty: false,
        );
    }

    public function renderChildTag(BlockStateInterface $Item)
    {
        return (string) new TagRender(
            tag: $Item->getProperty('tag') ?? 'li',
            attributes: $Item->getAttributes(),
            content: (string) $Item,
            isEmpty: false,
        );
    }
}
