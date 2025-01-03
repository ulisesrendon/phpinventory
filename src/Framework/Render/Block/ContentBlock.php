<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\HyperRenderApplication;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ContentBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {

        $HyperRenderApp = new HyperRenderApplication(
            id: $State->getValue() ?? $State->getProperty('layout'),
            HyperRender: $State->getLayoutNodes(),
            ContentNodes: [],
            Repo: $GlobalState->getRepo(),
            config: $GlobalState->getConfig(),
            renderConfig: $GlobalState->getRenderConfig(),
        );

        return $HyperRenderApp->getHyperRender()->render(false);
    }
}
