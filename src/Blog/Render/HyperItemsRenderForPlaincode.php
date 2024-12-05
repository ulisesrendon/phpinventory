<?php
namespace Stradow\Blog\Render;

class HyperItemsRenderForPlaincode implements \Stringable
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
        $value = htmlspecialchars($this->value);
        return "<pre><code>$value</code></pre>";
    }

    public function __toString(): string
    {
        return $this->render();
    }
}