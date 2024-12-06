<?php
namespace Stradow\Blog\Render;

use Stradow\Blog\Render\Interface\NestableInterface;
use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class HyperNode implements NodeContextInterface, NestableInterface
{
    private RendereableInterface $render;

    private array $children = [];

    private mixed $id;

    private mixed $parent;

    private mixed $value;

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
        // if(count($this->getChildren())){
        //     throw new \Exception('Imposible to render multidimensional node');
        // }

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
}

