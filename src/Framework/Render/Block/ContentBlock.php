<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Data\ContentState;
use Stradow\Framework\Render\HyperItemsRender;
use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ContentBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $ContentId = $State->getValue();
        $BlockContent = $Content->getRepo()?->getContent($ContentId);

        if (empty($BlockContent)) {
            throw new \DomainException("Content not found ($ContentId)");
        }

        $HyperRender = new HyperItemsRender;
        $ContentState = new ContentState(
            id: $BlockContent->id,
            path: $BlockContent->path,
            title: $BlockContent->title,
            properties: $BlockContent->properties,
            active: $BlockContent->active,
            type: $BlockContent->type,
            Root: $HyperRender,
            Repo: $Content->getRepo(),
            config: $Content->getConfig(),
        );
        foreach ($Content->getRepo()->getContentNodes($BlockContent->id) as $item) {
            $HyperRender->addNode(new HyperNode(
                id: $item->id,
                value: $item->value,
                properties: $item->properties,
                type: $item->type ?? 'default',
                parent: $item->parent,
                RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                Content: $ContentState,
            ));
        }

        return $HyperRender->render();
    }
}
