<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ListBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $content = array_reduce($State->getChildren(), fn ($carry, $item) => "$carry<li>$item</li>");

        $tag = $State->getProperty('type') ?? 'ul';
        $listType = $State->getProperty('listType');

        $properties = is_null($listType) ? '' : " type=\"$listType\"";

        return "<{$tag}{$properties}>{$content}</{$tag}>";
    }
}
