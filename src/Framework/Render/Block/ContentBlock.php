<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\HyperRenderApplication;
use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ContentBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $HyperRenderApp = new HyperRenderApplication(
            id: $State->getValue() ?? $State->getProperty('layout'),
            Repo: $Content->getRepo(),
            config: $Content->getConfig(),
            renderConfig: $Content->getRenderConfig(),
        );

        return $HyperRenderApp->getHyperRender()->render(false);
    }
}
