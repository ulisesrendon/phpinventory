<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class ImgBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $attributes = $State->getAttributes();
        $attributes['src'] ??= $State->getValue();

        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? 'img',
            attributes: $attributes,
            isEmpty: true,
        );
    }
}
