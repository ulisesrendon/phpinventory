<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class PlainCodeBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $value = htmlspecialchars($State->getValue());

        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? 'pre',
            attributes: $State->getAttributes(),
            content: "<code>$value</code>",
            isEmpty: false,
        );
    }
}
