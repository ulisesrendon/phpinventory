<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class TableBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $type = $Context->getProperties()['type'];

        $content = '';

        if ($type == 'table') {
            $tag = 'table';
            foreach ($Context->getChildren() as $row) {
                $content .= $row;
            }
        } else if ($type == 'row') {
            $tag = 'tr';
            foreach ($Context->getChildren() as $cell) {
                $content .= $cell;
            }
        } else if ($type == 'cell') {
            $tag = 'td';
            $content = $Context->getValue();
        } else if ($type == 'table-heading') {
            $tag = 'th';
            $content = $Context->getValue();
        }

        return "<{$tag}>{$content}</{$tag}>";
    }
}