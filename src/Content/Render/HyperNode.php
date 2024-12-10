<?php
namespace Stradow\Content\Render;

use Stradow\Content\Render\Interface\NestableInterface;
use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class HyperNode implements NodeContextInterface, NestableInterface
{
    private RendereableInterface $render;

    private array $children = [];

    private mixed $id;

    private mixed $parent;

    private mixed $value;

    private array $properties = [];

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

    public function setRender(RendereableInterface $render)
    {
        $this->render = $render;
    }

    public function __tostring(): string 
    {
        return $this->render->render($this);
    }

    public function setId(mixed $id)
    {
        $this->id = $id;
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function getParent(): mixed
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
}

