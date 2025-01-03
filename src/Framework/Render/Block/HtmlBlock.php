<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class HtmlBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
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
