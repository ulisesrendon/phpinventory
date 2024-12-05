<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForH1 implements \Stringable
{
    public mixed $value;

    public function __construct(
        mixed $value = null,
        ?object $properties = null,
        array $children = []
    ) {
        $this->value = $value;
    }

    public function render(): string
    {
        return "<h1>$this->value</h1>";
    }

    public function __toString(): string
    {
        return $this->render();
    }
}