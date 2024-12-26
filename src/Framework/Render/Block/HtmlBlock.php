<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class HtmlBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {

        if ($State->getProperty('tag')) {
            return (string) new TagRender(
                tag: $State->getProperty('tag'),
                attributes: $State->getAttributes(),
                content: $State->getValue() ?? '',
                isEmpty: $State->getProperty('isEmpty') ?? false,
            );
        }

        return $State->getValue();
    }
}
