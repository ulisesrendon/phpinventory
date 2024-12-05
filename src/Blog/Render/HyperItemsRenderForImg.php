<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForImg implements \Stringable
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
        return "<img src=\"$this->value\">";
    }

    public function __toString(): string
    {
        return $this->render();
    }
}