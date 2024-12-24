<?php

namespace Stradow\Framework\Render;

use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;

class HyperItemsRender
{
    /**
     * @var array<scalar,NestableInterface&NodeStateInterface>
     */
    public array $nodes = [];

    /**
     * @param  NestableInterface&NodeStateInterface[]  $items
     */
    public function __construct(
        array $items = [],
    ) {
        $this->nodes = $this->mapGenerator($items);
    }

    public function addNode(NestableInterface&NodeStateInterface $Node)
    {
        $this->nodes[$Node->getId()] = $Node;
    }

    /**
     * @param  NodeStateInterface[]  $items
     * @return NodeStateInterface[]
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
     * @param  NestableInterface&NodeStateInterface[]  $items
     * @return NestableInterface&NodeStateInterface[]
     */
    protected function treeGenerator(array $items): array
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
            callback: fn (?string $carry, \Stringable $item): string => $carry.$item
        ) ?? '';

        if ($prettify) {
            $renderOutput = self::class::prettify($renderOutput);
        }

        return $renderOutput;
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
            'strict-error-checking' => false,
        ];

        $replace = [
            '@' => 'at------',
        ];

        $html = str_replace(array_keys($replace), array_values($replace), $html);
        $html = tidy_parse_string($html, $config, 'utf8');
        tidy_clean_repair($html);
        $html = str_replace(array_values($replace), array_keys($replace), $html);
        return (string) $html;
    }

    public static function minify($html): string
    {
        $config = [
            'show-body-only' => true,
            'indent' => false,
            'drop-empty-elements' => 0,
            'new-blocklevel-tags' => 'article aside audio bdi canvas details dialog figcaption figure footer header hgroup main menu menuitem nav section source summary template track video',
            'new-empty-tags' => 'command embed keygen source track wbr',
            'new-inline-tags' => 'audio command datalist embed keygen mark menuitem meter output progress source time video wbr',
            'tidy-mark' => 0,
            'indent-spaces' => 4,
            'strict-error-checking' => false,
            'wrap' => 0,
            'clean' => true,
            'output-html' => true,
            'hide-comments' => true,
        ];

        $replace = [
            '@' => 'at------',
        ];

        $html = str_replace(array_keys($replace), array_values($replace), $html);
        $html = tidy_parse_string($html, $config, 'utf8');
        tidy_clean_repair($html);
        $html = str_replace(array_values($replace), array_keys($replace), $html);
        return (string) $html;
    }
}
