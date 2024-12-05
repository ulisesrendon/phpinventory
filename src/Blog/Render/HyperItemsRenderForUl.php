<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForUl implements \Stringable
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
        $content = array_reduce($this->children, fn($carry, $item) => $carry . "<li>$item</li>");

        return "<ul>$content</ul>";
    }

    public function __toString(): string
    {
        return $this->render();
    }
}