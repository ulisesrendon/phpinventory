<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForItem implements \Stringable
{
    public mixed $value;

    public function __construct(
        mixed $value = null, 
        ?object $properties = null,
        array $children = []
    )
    {
        $this->value = $value;
    }

    public function render(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}

