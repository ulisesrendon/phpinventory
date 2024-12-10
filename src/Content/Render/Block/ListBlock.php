<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ListBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        $blockProperties = $context->getProperties();

        $content = array_reduce($context->getChildren(), fn($carry, $item) => $carry . "<li>$item</li>");

        $tag = $blockProperties['type'];

        $properties = '';

        if(isset($blockProperties['listType'])){
            $properties = " type=\"{$blockProperties['listType']}\"";
        }

        return "<{$tag}{$properties}>{$content}</{$tag}>";
    }
}