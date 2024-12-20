<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Config;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Render\HyperItemsRender;
use Stradow\Framework\Render\HyperNode;
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
        $SiteConfig = Container::get(Config::class);

        $ContentNodes = $ContentRepo->getContentNodes($Content->id);
        $HyperRender = new HyperItemsRender;
        foreach ($ContentNodes as $item) {
            $HyperRender->addNode(
                id: $item->id,
                node: new HyperNode(
                    id: $item->id,
                    value: $item->value,
                    properties: $item->properties,
                    type: $item->type ?? 'default',
                    parent: $item->parent,
                    RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                    context: [
                        'Content' => $Content,
                        'Tree' => $HyperRender,
                        'Repo' => $ContentRepo,
                        'Config' => $SiteConfig,
                    ],
                )
            );
        }

        return $HyperRender->render();
    }
}
