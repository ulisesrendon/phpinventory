<?php

namespace Stradow\Framework\Render;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

final class HyperNode implements \Stringable, NestableInterface, NodeStateInterface
{
    private RendereableInterface $RenderEngine;

    private array $children = [];

    private mixed $id;

    private mixed $parent;

    private mixed $value;

    private string $type;

    private array $properties = [];

    private array $attributes = [];

    private ?HyperItemsRender $LayoutNodes;

    private ContentStateInterface $Content;

    public function __construct(
        string|int|float $id,
        mixed $value,
        array $properties,
        string|int|float $type,
        null|string|int|float $parent,
        RendereableInterface $RenderEngine,
        ContentStateInterface $Content,
        ?HyperItemsRender $LayoutNodes = null,
    ) {
        $this->setId($id);
        $this->setValue($value);
        $this->setProperties([
            ...$properties,
            'id' => $id,
            'type' => $type,
        ]);
        $this->setAttributes();
        $this->setParent($parent);
        $this->setRenderEngine($RenderEngine);
        $this->Content = $Content;
        $this->type = $type;
        $this->LayoutNodes = $LayoutNodes;
    }

    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    public function setParent(mixed $parent)
    {
        $this->parent = $parent;
    }

    public function setRenderEngine(RendereableInterface $RenderEngine)
    {
        $this->RenderEngine = $RenderEngine;
    }

    public function getRender(): string
    {
        return $this->RenderEngine->render($this, $this->Content);
    }

    public function __toString(): string
    {
        return $this->getRender();
    }

    public function setId(mixed $id)
    {
        $this->id = $id;
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function getParent(): null|string|int|float
    {
        return $this->parent;
    }

    public function addChild(object $child)
    {
        $this->children[] = $child;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function setProperties(array $properties = [])
    {
        $this->properties = $properties;
    }

    public function setProperty(string $name, mixed $value)
    {
        $this->properties[$name] = $value;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getProperty(string $key): mixed
    {
        return isset($this->properties[$key]) ? $this->properties[$key] ?? null : null;
    }

    public function unsetProperty($name)
    {
        unset($this->properties[$name]);
    }

    private function setAttributes(): void
    {
        $attributes = [];
        if (! is_null($this->getProperty('attributes'))) {
            $attributes = $this->getProperty('attributes');
        }

        if (
            isset($attributes['class'])
            && gettype($attributes['class']) === 'string'
        ) {
            $attributes['class'] = explode(' ', $attributes['class']);
        }

        if (! is_null($this->getProperty('classList'))) {
            $attributes['class'] ??= [];
            $attributes['class'] = array_unique([...$attributes['class'], ...$this->getProperty('classList')]);
        }

        if (isset($attributes['class'])) {
            $attributes['class'] = implode(' ', $attributes['class']);
        }

        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getLayoutNodes(): ?HyperItemsRender
    {
        return $this->LayoutNodes;
    }
}
