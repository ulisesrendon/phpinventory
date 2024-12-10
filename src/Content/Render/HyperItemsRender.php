<?php

namespace Stradow\Content\Render;

use Stradow\Content\Render\Interface\NestableInterface;
use Stradow\Content\Render\Interface\NodeContextInterface;

class HyperItemsRender
{
    /**
     * Summary of nodes
     * @var NestableInterface&NodeContextInterface[] $nodes
     */
    private array $nodes = [];

    /**
     * @param NestableInterface&NodeContextInterface[] $items
     * @param array<string, class-string> $config
     */
    public function __construct(array $items)
    {
        // Generate map structure
        $nodeMap = [];
        foreach ($items as $k => $item) {
            $nodeMap[$item->getId()] = $items[$k];
        }

        $this->nodes = $nodeMap;
    }
    
    public function render(): string
    {
        $nodeTree = [];

        // Generate tree structure
        foreach ($this->nodes as $k => $item) {
            if (!is_null($item->getParent())) {
                $this->nodes[$item->getParent()]->addChild($this->nodes[$k]);
            } else {
                $nodeTree[] = &$this->nodes[$k];
            }
        }

        return array_reduce(
            array: $nodeTree, 
            callback: fn(?string $carry, \Stringable $item): string => $carry.$item
        );
    }
}

