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
     *
     * @param  scalar  $id
     *
     * @throws \DomainException
     */
    public function __construct(
        int|float|string $id,
        RepoInterface $Repo,
        array $config,
        array $renderConfig, ?object $Content = null,
        bool $renderLayout = true,
    ) {
        $this->HyperRender = new HyperItemsRender;
        $this->Repo = $Repo;
        $this->renderConfig = $renderConfig;
        $this->config = $config;

        $this->Content = $Content ?? $this->Repo->getContent($id);

        if (empty($this->Content)) {
            throw new \DomainException("Content not found ($id)");
        }

        $this->ContentNodes = $this->Repo->getContentNodes($this->Content->id);

        $this->ContentState = $this->contentStateBuild();

        if (
            $renderLayout
            && isset($this->Content->properties->layout)
            && isset($this->Content->properties->layoutContainer)
        ) {
            $this->ContentNodes = $this->addLayoutNodes($this->ContentNodes);
        }

        foreach ($this->ContentNodes as $item) {
            $this->HyperRender->addNode($this->hyperNodeBuild($item));
        }
    }

    private function addLayoutNodes(array $ContentNodes)
    {
        $RootNode = $this->Content->properties->layoutContainer;
        $LayoutNodes = $this->Repo->getContentNodes($this->Content->properties->layout);
        foreach ($ContentNodes as $item) {
            $item->parent ??= $RootNode;
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

    private function hyperNodeBuild(object $item): NestableInterface&NodeStateInterface
    {
        return new HyperNode(
            id: $item->id,
            value: $item->value,
            properties: $item->properties,
            type: $item->type,
            parent: $item->parent,
            RenderEngine: new ($this->renderConfig[$item->type] ?? $this->renderConfig['default']),
            Content: $this->ContentState,
        );
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
