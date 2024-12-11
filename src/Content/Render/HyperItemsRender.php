<?php

namespace Stradow\Content\Render;

use Stradow\Content\Render\HyperNode;
use Stradow\Content\Render\Interface\NestableInterface;
use Stradow\Content\Render\Interface\NodeContextInterface;

class HyperItemsRender
{
    /**
     * Summary of nodes
     * @var array<scalar,NestableInterface&NodeContextInterface> $nodes
     */
    private array $nodes = [];

    /**
     * @param NestableInterface&NodeContextInterface[] $items
     */
    public function __construct(
        array $items = [],
    )
    {
        $this->nodes = $this->mapGenerator($items);;
    }

    public function addNode(string|int|float $id, NestableInterface&NodeContextInterface $node)
    {
        $this->nodes[$id] = $node;
    }

    /**
     * @param NodeContextInterface[] $items
     * @return NodeContextInterface[]
     */
    protected function mapGenerator(array $items): array
    {
        $nodeMap = [];
        foreach ($items as $k => $item) {
            $nodeMap[$item->getId()] = &$items[$k];
        }
        return $nodeMap;
    }


    /**
     * @param NestableInterface&NodeContextInterface[] $items
     * @return NestableInterface&NodeContextInterface[]
     */
    protected function treeGenerator(array $items): array
    {
        $nodeTree = [];
        foreach ($items as $k => $item) {
            if (!is_null($item->getParent())) {
                $items[$item->getParent()]->addChild($items[$k]);
            } else {
                $nodeTree[] = &$items[$k];
            }
        }
        return $nodeTree;
    }

    public function render(): string
    {

        // Generate tree structure
        $nodeTree = $this->treeGenerator($this->nodes);

        return array_reduce(
            array: $nodeTree,
            callback: fn(?string $carry, \Stringable $item): string => $carry . $item
        ) ?? '';
    }
}

