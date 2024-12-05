<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderDefault implements \Stringable
{
    public mixed $value;
    public object $properties;
    public array $children;

    public function __construct(
        mixed $value = null,
        ?object $properties = null,
        array $children = []
    ) {
        $this->value = $value;
        $this->properties = $properties;
        $this->children = $children;
    }

    public function render(): string
    {
        return json_encode([
            'value' => $this->value,
            'properties' => $this->properties,
            'children' => $this->children,
        ]);
    }

    public function __toString(): string
    {
        return $this->render();
    }
}