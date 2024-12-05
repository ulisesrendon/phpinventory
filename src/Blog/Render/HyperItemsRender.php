<?php

namespace Stradow\Blog\Render;

class HyperItemsRender
{

    private array $config;
    private array $nodesAll = [];
    private array $nodesBase = [];

    /**
     * @param object[] $items
     * @param array<string, class-string> $config
     */
    public function __construct(array $items, array $config)
    {
        $this->config = $config;

        foreach ($items as $k => $item) {
            $this->nodesAll[$item->id] = &$items[$k];
        }

        foreach ($this->nodesAll as $k => $item) {
            if (!is_null($item->parent)) {
                $this->nodesAll[$item->parent]->children[] = &$this->nodesAll[$k];
            } else {
                $this->nodesBase[] = &$this->nodesAll[$k];
            }
        }

        foreach ($this->nodesAll as $k => $item) {
            $this->nodesAll[$k] = $this->fabric(
                $item->type,
                $item->value,
                $item->properties,
                $item->children,
            );
        }
    }

    public function getNodes()
    {
        return $this->nodesBase;
    }

    public function fabric(
        string $type = '',
        mixed $value = null,
        ?object $properties = null,
        array $children = []
    ): \Stringable {

        $render = $this->config[$type] ?? null;

        if(!isset($render)){
            $render = $this->config['default'];
        }

        return new $render($value, $properties, $children);
    }

    public function render()
    {
        return array_reduce($this->getNodes(), fn($carry, $item) => $carry . $item);
    }
}

