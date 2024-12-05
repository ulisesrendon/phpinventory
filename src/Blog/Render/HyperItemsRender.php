<?php

namespace Stradow\Blog\Render;

class HyperItemsRender
{

    private array $config;
    private array $nodes = [];

    /**
     * @param object[] $items
     * @param array<string, class-string> $config
     */
    public function __construct(array $items, array $config)
    {
        $this->config = $config;

        $Tree = new HyperTreeMap($items);

        foreach ($Tree as $k => $item) {
            $Tree[$k] = $this->fabric(
                $item->type,
                $item->value,
                $item->properties,
                $item->children,
            );
        }

        $this->nodes = $Tree->getNodes();
    }

    public function getNodes()
    {
        return $this->nodes;
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

