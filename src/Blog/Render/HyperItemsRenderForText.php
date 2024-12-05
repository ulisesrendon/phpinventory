<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForText implements \Stringable
{
    public array $children;

    public function __construct(
        mixed $value = null,
        ?object $properties = null,
        array $children = []
    ) {
        $this->children = $children;
    }

    public function render(): string
    {
        $content = array_reduce($this->children, fn($carry, $item) => $carry . "<p>$item</p>");

        return "<div>$content</div>";
    }

    public function __toString(): string
    {
        return $this->render();
    }
}