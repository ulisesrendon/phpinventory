<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class ImgBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {
        if ($State->isTemplated()) {
            return (string) new TemplateRender(CONTENT_DIR."/{$State->getProperty('template')}", [
                'BlockState' => $State,
                'GlobalState' => $GlobalState,
                'Config' => $GlobalState->getConfig(),
                'TagRender' => TagRender::class,
                'TemplateRender' => TemplateRender::class,
            ]);
        }

        $attributes = $State->getAttributes();
        $attributes['src'] ??= $State->getValue();

        return (string) new TagRender(
            tag: $State->getProperty('tag') ?? 'img',
            attributes: $attributes,
            isEmpty: true,
        );
    }
}
