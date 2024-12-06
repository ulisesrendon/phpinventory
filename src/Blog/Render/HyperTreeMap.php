<?php
namespace Stradow\Blog\Render;

class HyperTreeMap implements \Iterator, \ArrayAccess
{
    private int $position = 0;
    private array $items = [];
    private array $nodes = [];


    public function __construct(array $items)
    {
        $nodeTree = [];
        $nodeMap = [];
        
        // Generate map structure
        foreach ($items as $k => $item) {
            $nodeMap[$item->id] = $items[$k];
        }

        // Generate tree structure
        foreach ($nodeMap as $k => $item) {
            if (!is_null($item->parent)) {
                $nodeMap[$item->parent]->children[] = &$nodeMap[$k];
            } else {
                $nodeTree[] = &$nodeMap[$k];
            }
        }

        $this->items = array_values($nodeMap);

        $this->nodes = array_values($nodeTree);
    }

    public function current(): mixed
    {
        return $this->items[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function getNodes()
    {
        return $this->nodes;
    }

    public function __get($key)
    {
        return $this->items[$key] ?? null;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}