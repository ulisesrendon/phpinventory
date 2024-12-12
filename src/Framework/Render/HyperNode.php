<?php

namespace Stradow\Framework\Render;

use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class HyperNode implements NestableInterface, NodeContextInterface
{
    private RendereableInterface $RenderEngine;

    private array $children = [];

    private mixed $id;

    private mixed $parent;

    private mixed $value;

    private array $properties = [];

    private readonly array $context;

    public function __construct(
        string|int|float $id,
        mixed $value,
        array $properties,
        string|int|float $type,
        null|string|int|float $parent,
        RendereableInterface $RenderEngine,
        array $context = [],
    ) {
        $this->setId($id);
        $this->setValue($value);
        $this->setProperties([
            ...$properties,
            'id' => $id,
            'type' => $type,
        ]);
        $this->setParent($parent);
        $this->setRenderEngine($RenderEngine);

        $this->context = $context;
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

    public function __toString(): string
    {
        return $this->RenderEngine->render($this);
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

    // public function setProperty($property)
    // {
    //     $this->properties[] = $property;
    // }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getExtra(string $key): mixed
    {
        return $this->context[$key] ?? null;
    }
}
