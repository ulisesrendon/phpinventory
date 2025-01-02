<?php

namespace Stradow\Framework\Render\Interface;

use Stradow\Framework\Render\HyperItemsRender;

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

    public function getLayoutNodes(): ?HyperItemsRender;

    public function getRender(): string;
}
