<?php

namespace Stradow\Framework\Render;

use Stradow\Framework\Render\Data\ContentState;
use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RepoInterface;

final class HyperRenderApplication
{
    private object $Content;

    private RepoInterface $Repo;

    private ContentStateInterface $ContentState;

    private HyperItemsRender $HyperRender;

    private array $ContentNodes;

    private array $config;

    private array $renderConfig;

    /**
     * @param  scalar  $id
     *
     * @throws \DomainException
     */
    public function __construct(
        int|float|string $id,
        RepoInterface $Repo,
        array $config,
        array $renderConfig,
        ?object $Content = null,
    ) {
        $this->HyperRender = new HyperItemsRender;
        $this->Repo = $Repo;
        $this->renderConfig = $renderConfig;
        $this->config = $config;

        $this->Content = $Content ?? $this->Repo->getContent($id);

        if (empty($this->Content)) {
            throw new \DomainException("Content not found ($id)");
        }

        $this->ContentState = $this->contentStateBuild();

        $this->ContentNodes = $this->prepareContentNodes();

    }

    private function addLayoutNodes(array $ContentNodes)
    {
        $RootNode = $this->Content->properties->layoutContainer;
        $LayoutNodes = $this->Repo->getContentNodes($this->Content->properties->layout);
        foreach ($ContentNodes as $Item) {
            $Item->parent ??= $RootNode;
        }

        return [...$LayoutNodes, ...$ContentNodes];
    }

    private function contentStateBuild(): ContentStateInterface
    {
        return new ContentState(
            id: $this->Content->id,
            path: $this->Content->path,
            title: $this->Content->title,
            properties: $this->Content->properties,
            active: $this->Content->active,
            type: $this->Content->type,
            Root: $this->HyperRender,
            Repo: $this->Repo,
            config: $this->config,
            renderConfig: $this->renderConfig,
        );
    }

    private function hyperNodeBuild(object $Item, object $ContentState): NestableInterface&NodeStateInterface
    {
        return new HyperNode(
            id: $Item->id,
            value: $Item->value,
            properties: $Item->properties,
            type: $Item->type,
            parent: $Item->parent,
            RenderEngine: new ($this->renderConfig[$Item->type] ?? $this->renderConfig['default']),
            Content: $ContentState,
            LayoutNodes: $Item->LayoutNodes,
        );
    }

    private function prepareContentNodes(): array
    {
        $ContentNodes = $this->Repo->getContentNodes($this->Content->id);
        $contentGroups = [];
        foreach ($ContentNodes as $k => $Node) {
            $Node->LayoutNodes = null;
            $contentGroups[$Node->content][] = $Node;
        }
        $MainNodes = $contentGroups[$this->Content->id];

        foreach ($MainNodes as $k => $Node) {
            if (! is_null($Node->layout)) {
                $LayoutNodes = new HyperItemsRender;
                foreach ($contentGroups[$Node->layout] as $Item) {
                    $NewItem = clone $Item;
                    if (is_null($NewItem->parent)) {
                        $NewItem->weight = $Node->weight;
                    }

                    $LayoutNodes->addNode($this->hyperNodeBuild($NewItem, $this->ContentState));
                }

                if ($Node->type !== 'content') {
                    $SelfNestedNode = clone $Node;
                    $SelfNestedNode->parent = $SelfNestedNode->layoutContainer;
                    $LayoutNodes->addNode($this->hyperNodeBuild($SelfNestedNode, $this->ContentState));
                }

                $MainNodes[$k]->LayoutNodes = $LayoutNodes;
            }

            $this->HyperRender->addNode($this->hyperNodeBuild($Node, $this->ContentState));
        }

        // usort($ContentNodes, function ($a, $b) {
        //     return ($a->weight < $b->weight) ? -1 : 1;
        // });

        // \Stradow\Framework\Helper\Dump::json($this->ContentNodes);

        return $MainNodes;
    }

    public function getHyperRender(): HyperItemsRender
    {
        return $this->HyperRender;
    }

    public function getContent(): object
    {
        return $this->Content;
    }
}
