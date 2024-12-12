<?php

namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\HyperNode;
use Stradow\Content\Render\HyperItemsRender;
use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ContentBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        /**
         * @var \Stradow\Content\Data\ContentRepo $ContentRepo
         */
        $ContentRepo = $Context->getExtra('repo');

        $Content = $ContentRepo?->getContentById($Context->getValue());

        $HyperRender = new HyperItemsRender;

        foreach ($Content->nodes as $item) {
            $HyperRender->addNode(
                id: $item->id,
                node: new HyperNode(
                    id: $item->id,
                    value: $item->value,
                    properties: $item->properties,
                    type: $item->type,
                    parent: $item->parent,
                    RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                    context: [
                        'tree' => $HyperRender,
                        'repo' => $ContentRepo,
                    ],
                )
            );
        }

        return $HyperRender->render();
    }
}