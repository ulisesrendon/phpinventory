<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class TableBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {

        if ($State->isTemplated()) {
            return (string) new TemplateRender(CONTENT_DIR."/{$State->getProperty('template')}", [
                'BlockState' => $State,
                'GlobalState' => $GlobalState,
                'Config' => $GlobalState->getConfig(),
                'TagRender' => TagRender::class,
                'TemplateRender' => TemplateRender::class,
            ]);
        }

        $tags = [
            'table' => 'table',
            'row' => 'tr',
            'table-heading' => 'th',
            'cell' => 'td',
        ];

        $childrenContent = array_reduce($State->getChildren(), fn (?string $carry, $Item): string => $carry.$Item) ?? '';

        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? $tags[$State->getProperty('type')] ?? 'table',
            attributes: $State->getAttributes(),
            content: ! empty($childrenContent) ? $childrenContent : $State->getValue() ?? '',
            isEmpty: false,
        );
    }
}
