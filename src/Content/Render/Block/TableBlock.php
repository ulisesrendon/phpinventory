<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class TableBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        $type = $context->getProperties()['type'];

        $content = '';

        if ($type == 'table') {
            $tag = 'table';
            foreach ($context->getChildren() as $row) {
                $content .= $row;
            }
        } else if ($type == 'row') {
            $tag = 'tr';
            foreach ($context->getChildren() as $cell) {
                $content .= $cell;
            }
        } else if ($type == 'cell') {
            $tag = 'td';
            $content = $context->getValue();
        } else if ($type == 'table-heading') {
            $tag = 'th';
            $content = $context->getValue();
        }

        return "<{$tag}>{$content}</{$tag}>";
    }
}