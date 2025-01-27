<?php

namespace Stradow\Framework\Render;

use Stradow\Framework\Render\Data\GlobalState;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\RepoInterface;

final class HyperRenderApplication
{
    private object $Content;

    private RepoInterface $Repo;

    private GlobalStateInterface $GlobalState;

    private HyperRender $HyperRender;

    private array $ContentNodes;

    private object $config;

    private array $renderConfig;

    private static array $Contents = [];

    /**
     * @param  scalar  $id
     * @param  class-string[]  $renderConfig
     *
     * @throws \DomainException
     */
    public function __construct(
        int|float|string $id,
        RepoInterface $Repo,
        object $config,
        array $renderConfig,
        ?object $Content = null,
        ?object $HyperRender = null,
        ?array $ContentNodes = null,
    ) {
        $this->HyperRender = $HyperRender ?? new HyperRender;
        $this->Repo = $Repo;
        $this->renderConfig = $renderConfig;
        $this->config = $config;

        self::$Contents[$id] ??= $this->Repo->getContent($id);

        $this->Content = $Content ?? self::$Contents[$id];

        if (empty($this->Content)) {
            throw new \DomainException("Content not found ($id)");
        }

        $this->GlobalState = $this->contentStateBuild();

        $this->ContentNodes = $ContentNodes ?? $this->prepareContentNodes();
    }

    private function contentStateBuild(): GlobalStateInterface
    {
        return new GlobalState(
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

    private function hyperNodeBuild(object $Item, object $ContentState): NestableInterface&BlockStateInterface
    {
        return new HyperNode(
            id: $Item->id,
            value: $Item->value,
            properties: $Item->properties,
            type: $Item->type,
            parent: $Item->parent,
            RenderEngine: new ($this->renderConfig[$Item->type] ?? $this->renderConfig['default']),
            GlobalState: $ContentState,
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
        $MainNodes = $contentGroups[$this->Content->id] ?? [];

        foreach ($MainNodes as $k => $Node) {
            if (! is_null($Node->layout)) {
                $Node->LayoutNodes = new HyperRender;
                foreach ($contentGroups[$Node->layout] as $subNode) {
                    $Node->LayoutNodes->addNode($this->hyperNodeBuild($subNode, $this->GlobalState));
                }
            }
            $this->HyperRender->addNode($this->hyperNodeBuild($Node, $this->GlobalState));
        }

        return $ContentNodes;
    }

    public function getHyperRender(): HyperRender
    {
        return $this->HyperRender;
    }

    public function getContent(): object
    {
        return $this->Content;
    }
}
