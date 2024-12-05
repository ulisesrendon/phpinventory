<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForContainer implements \Stringable
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
        $content = implode('', $this->children);
        return "<div>$content</div>";
    }

    public function __toString(): string
    {
        return $this->render();
    }
}