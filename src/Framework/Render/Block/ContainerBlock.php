<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\Interface\ContentStateInterface;

class ContainerBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $ChildContent = array_reduce($State->getChildren(), fn ($carry, $item) => $carry.$item);

        $tag = $State->getProperty('tag') ?? 'div';

        $attributes = $State->getAttributes();

        $attributesPrepared = '';
        if(!empty($attributes)){
            ksort($attributes);
            $attributesPrepared = [];
            foreach($attributes as $name => $value){
                $attributesPrepared[] = "$name=\"$value\"";
            }
            $attributesPrepared = ' '.implode(' ', $attributesPrepared);
        }

        return "<{$tag}{$attributesPrepared}>$ChildContent</$tag>";
    }
}
