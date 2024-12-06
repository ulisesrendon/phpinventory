<?php
namespace Stradow\Blog\Render\Interface;

interface NodeContextInterface
{
    public function getValue();

    public function getId();

    public function getChildren(): array;
}