<?php
namespace Stradow\Content\Render\Interface;

interface NodeContextInterface
{
    public function getValue();

    public function getId();

    public function getChildren(): array;

    public function getProperties(): array;
}