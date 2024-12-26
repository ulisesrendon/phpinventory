<?php

namespace Stradow\Framework\Render;

class TagRender implements \Stringable
{
    /**
     * @param  array<string, string>  $attributes
     */
    public function __construct(
        private string $tag,
        private array $attributes = [],
        private string $content = '',
        private bool $isEmpty = true,
    ) {}

    public function renderAttributes(array $attributes): string
    {
        ksort($attributes);
        $attributesPrepared = [];
        foreach ($attributes as $name => $value) {
            $attributesPrepared[] = "$name=\"$value\"";
        }

        return implode(' ', $attributesPrepared);
    }

    public function get(): string
    {
        $tagDefinition = $this->tag;

        if (! empty($this->attributes)) {
            $tagDefinition .= " {$this->renderAttributes($this->attributes)}";
        }

        if ($this->isEmpty) {
            return "<$tagDefinition>";
        }

        return "<{$tagDefinition}>{$this->content}</{$this->tag}>";
    }

    public function __toString(): string
    {
        return $this->get();
    }
}
