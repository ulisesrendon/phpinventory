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
        $type = $State->getProperty('type');

        $content = '';

        if ($type == 'table') {
            $tag = $State->getProperty('tag') ?? 'table';
            foreach ($State->getChildren() as $row) {
                $content .= $row;
            }
        } elseif ($type == 'row') {
            $tag = $State->getProperty('tag') ?? 'tr';
            foreach ($State->getChildren() as $cell) {
                $content .= $cell;
            }
        } elseif ($type == 'cell') {
            $tag = $State->getProperty('tag') ?? 'td';
            $content = $State->getValue();
        } elseif ($type == 'table-heading') {
            $tag = $State->getProperty('tag') ?? 'th';
            $content = $State->getValue();
        }

        return (string) new TagRender(
            tag: $tag,
            attributes: $State->getAttributes(),
            content: $content,
            isEmpty: false,
        );
    }
}
