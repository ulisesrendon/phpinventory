<?php

namespace Stradow\Framework\Render;

use Stradow\Framework\Render\Helper\HyperCodePrettify;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\PrettifierInterface;

final class HyperItemsRender
{
    /**
     * @var array<scalar,NestableInterface&BlockStateInterface>
     */
    public array $nodes = [];

    private PrettifierInterface $Prettifier;

    /**
     * @param  NestableInterface&BlockStateInterface[]  $items
     * @param  class-string<PrettifierInterface>  $Prettifier
     */
    public function __construct(
        array $items = [],
        string $Prettifier = HyperCodePrettify::class,
    ) {
        $this->nodes = $this->mapGenerator($items);
        $this->Prettifier = new $Prettifier;
    }

    public function addNode(NestableInterface&BlockStateInterface $Node)
    {
        $this->nodes[$Node->getId()] = $Node;
    }

    /**
     * @param  BlockStateInterface[]  $items
     * @return BlockStateInterface[]
     */
    private function mapGenerator(array $items): array
    {
        $nodeMap = [];
        foreach ($items as $k => $item) {
            $nodeMap[$item->getId()] = &$items[$k];
        }

        return $nodeMap;
    }

    /**
     * @param  NestableInterface&BlockStateInterface[]  $items
     * @return NestableInterface&BlockStateInterface[]
     */
    private function treeGenerator(array $items): array
    {
        $nodeTree = [];
        foreach ($items as $k => $item) {
            if (! is_null($item->getParent()) && isset($items[$item->getParent()])) {
                $items[$item->getParent()]->addChild($items[$k]);
            } else {
                $nodeTree[] = &$items[$k];
            }
        }

        return $nodeTree;
    }

    public function render(bool $prettify = true): string
    {
        // Generate tree structure
        $nodeTree = $this->treeGenerator($this->nodes);

        $renderOutput = array_reduce(
            array: $nodeTree,
            callback: [$this, 'reducer']
        ) ?? '';

        if ($prettify) {
            $renderOutput = $this->Prettifier->prettify($renderOutput);
        }

        return $renderOutput;
    }

    public function reducer(?string $carry, BlockStateInterface $Item): string
    {
        $LayoutNodes = $Item->getLayoutNodes();
        if (! is_null($LayoutNodes)) {
            $render = $Item->getLayoutNodes()->render();
        } else {
            $render = $Item->getRender();
        }

        return $carry.$render;
    }
}
