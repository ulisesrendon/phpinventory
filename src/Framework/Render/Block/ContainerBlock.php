<?php

namespace Stradow\Framework\Render\Block;

use DOMDocument;
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

        $attributes = [];
        if(
            !is_null($State->getProperty('attributes'))
        ){
            $attributes = $State->getProperty('attributes');
        }

        if(
            isset($attributes['class']) 
            && 'string' === gettype($attributes['class'])
        ){
            $attributes['class'] = explode(' ', $attributes['class']);
        }

        if(
            !is_null($State->getProperty('classList'))
        ){
            $attributes['class'] ??= [];

            $attributes['class'] = array_unique([...$attributes['class'], ...$State->getProperty('classList')]);
        }

        if(isset($attributes['class'])){
            $attributes['class'] = implode(' ', $attributes['class']);
        }

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
