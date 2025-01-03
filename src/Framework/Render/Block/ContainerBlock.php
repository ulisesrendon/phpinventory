<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class ContainerBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {
        if ($State->isTemplated()) {
            return (string) new TemplateRender(CONTENT_DIR."/{$State->getProperty('template')}", [
                'BlockState' => $State,
                'GlobalState' => $GlobalState,
                'TagRender' => TagRender::class,
                'TemplateRender' => TemplateRender::class,
            ]);
        }

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
