<?php

namespace Stradow\Content\Render;

use Stradow\Content\Render\Interface\NestableInterface;
use Stradow\Content\Render\Interface\NodeContextInterface;

class HyperItemsRender
{
    /**
     * Summary of nodes
     *
     * @var array<scalar,NestableInterface&NodeContextInterface>
     */
    private array $nodes = [];

    /**
     * @param  NestableInterface&NodeContextInterface[]  $items
     */
    public function __construct(
        array $items = [],
    ) {
        $this->nodes = $this->mapGenerator($items);
    }

    public function addNode(string|int|float $id, NestableInterface&NodeContextInterface $node)
    {
        $this->nodes[$id] = $node;
    }

    /**
     * @param  NodeContextInterface[]  $items
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
     * @param  NestableInterface&NodeContextInterface[]  $items
     * @return NestableInterface&NodeContextInterface[]
     */
    protected function treeGenerator(array $items): array
    {
        $nodeTree = [];
        foreach ($items as $k => $item) {
            if (! is_null($item->getParent())) {
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

        $renderOutput = array_reduce(
            array: $nodeTree,
            callback: fn (?string $carry, \Stringable $item): string => $carry.$item
        ) ?? '';

        return self::class::prettify($renderOutput);
    }

    public static function prettify($html): string
    {
        $config = [
            'show-body-only' => true,
            'indent' => true,
            'drop-empty-elements' => 0,
            'new-blocklevel-tags' => 'article aside audio bdi canvas details dialog figcaption figure footer header hgroup main menu menuitem nav section source summary template track video',
            'new-empty-tags' => 'command embed keygen source track wbr',
            'new-inline-tags' => 'audio command datalist embed keygen mark menuitem meter output progress source time video wbr',
            'tidy-mark' => 0,
            'indent-spaces' => 4,
        ];
        $html = tidy_parse_string($html, $config, 'utf8');
        tidy_clean_repair($html);

        return (string) $html;
    }
}
