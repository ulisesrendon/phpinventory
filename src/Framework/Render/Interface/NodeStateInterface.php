<?php

namespace Stradow\Framework\Render\Interface;

interface NodeStateInterface
{
    public function getValue();

    public function getId();

    /**
     * @return NodeStateInterface[]
     */
    public function getChildren(): array;

    public function getProperty(string $key): mixed;

    public function getProperties(): array;

    public function getAttributes(): array;

    public function getType(): string;
}
