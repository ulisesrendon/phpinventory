<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Render\HyperItemsRender;
use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ContentBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        /**
         * @var \Stradow\Content\Data\ContentRepo $ContentRepo
         */
        $ContentRepo = $Context->getExtra('Repo');

        $Content = $ContentRepo?->getContent($Context->getValue());

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
                        'Tree' => $HyperRender,
                        'Repo' => $ContentRepo,
                    ],
                )
            );
        }

        return $HyperRender->render();
    }
}
