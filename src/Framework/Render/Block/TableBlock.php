<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class TableBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $tags = [
            'table' => 'table',
            'row' => 'tr',
            'table-heading' => 'th',
            'cell' => 'td',
        ];

        $childrenContent = array_reduce($State->getChildren(), fn(?string $carry, $Item): string => $carry.$Item) ?? '';

        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? $tags[$State->getProperty('type')] ?? 'table',
            attributes: $State->getAttributes(),
            content: !empty($childrenContent) ? $childrenContent : $State->getValue() ?? '',
            isEmpty: false,
        );
    }
}
