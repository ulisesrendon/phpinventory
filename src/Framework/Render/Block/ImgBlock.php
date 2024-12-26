<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\HyperRenderApplication;
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
        
        if ($State->getProperty('layout') && $State->getProperty('layoutContainer')) {
            $properties = $State->getProperties();
            unset($properties['layout']);
            unset($properties['layoutContainer']);

            $HyperRenderApp = new HyperRenderApplication(
                id: $State->getProperty('layout'),
                Repo: $Content->getRepo(),
                config: $Content->getConfig(),
                renderConfig: $Content->getRenderConfig(),
                renderLayout: false,
                extraNodes: [
                    (object) [
                        'id' => $State->getId(),
                        'parent' => $State->getProperty('layoutContainer'),
                        'value' => $State->getValue(),
                        'properties' => $properties,
                        'type' => $State->getType(),
                    ],
                ],
            );

            return $HyperRenderApp->getHyperRender()->render(false);
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
