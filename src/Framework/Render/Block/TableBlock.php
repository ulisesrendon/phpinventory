<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class TableBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $type = $State->getProperty('type');

        $content = '';

        if ($type == 'table') {
            $tag = 'table';
            foreach ($State->getChildren() as $row) {
                $content .= $row;
            }
        } elseif ($type == 'row') {
            $tag = 'tr';
            foreach ($State->getChildren() as $cell) {
                $content .= $cell;
            }
        } elseif ($type == 'cell') {
            $tag = 'td';
            $content = $State->getValue();
        } elseif ($type == 'table-heading') {
            $tag = 'th';
            $content = $State->getValue();
        }

        return "<{$tag}>{$content}</{$tag}>";
    }
}
