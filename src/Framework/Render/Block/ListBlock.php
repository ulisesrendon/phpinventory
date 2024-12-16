<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ListBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $content = array_reduce($Context->getChildren(), fn ($carry, $item) => "$carry<li>$item</li>");

        $tag = $Context->getProperties('type') ?? 'ul';
        $listType = $Context->getProperties('listType');

        $properties = is_null($listType) ? '' : " type=\"$listType\"";

        return "<{$tag}{$properties}>{$content}</{$tag}>";
    }
}
