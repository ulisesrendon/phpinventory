<?php

namespace Stradow\Framework\Render;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Stradow\Framework\Render\Helper\HyperCodePrettify;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\PrettifierInterface;
use Traversable;

final class HyperItemsRender implements Countable, IteratorAggregate
{
    /**
     * @var array<scalar,NestableInterface&BlockStateInterface>
     */
    private array $nodes = [];

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

    private function reducer(?string $carry, BlockStateInterface $Item): string
    {
        $LayoutNodes = $Item->getLayoutNodes();
        if (! is_null($LayoutNodes)) {
            $render = $Item->getLayoutNodes()->render();
        } else {
            $render = $Item->getRender();
        }

        return $carry.$render;
    }

    /**
     * Returns a summary of the collection of nodes in a map-like schema
     *
     * @param  class-string[]  $renderConfig
     */
    public function getMapSchema(array $renderConfig = []): array
    {
        $schema = [];

        foreach ($this->nodes as $k => $node) {
            $schema[$k] = [
                'value' => $node->getValue(),
                'parent' => $node->getParent(),
                'properties' => $node->getProperties(),
                'render' => $renderConfig[$node->getType()] ?? null,
            ];
        }

        return $schema;
    }

    /**
     * Returns a summary of the collection of nodes in a tree-like schema
     *
     * @param  class-string[]  $renderConfig
     */
    public function getTreeSchema(array $renderConfig = []): array
    {
        $items = $this->getMapSchema($renderConfig);

        $nodeTree = [];
        foreach ($items as $k => $item) {
            $items[$k]['children'] ??= [];
            $item['children'] ??= [];

            if (! is_null($item['parent']) && isset($items[$item['parent']])) {
                $items[$item['parent']]['children'][] = $item;
            } else {
                $nodeTree[$k] = &$items[$k];
            }
        }

        return $nodeTree;
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->nodes);
    }
}
