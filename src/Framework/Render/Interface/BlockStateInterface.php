<?php

namespace Stradow\Framework\Render\Interface;

use Stradow\Framework\Render\HyperRender;

interface BlockStateInterface
{
    public function getValue();

    public function getId();

    /**
     * @return BlockStateInterface[]
     */
    public function getChildren(): array;

    public function getProperty(string $key): mixed;

    public function getProperties(): array;

    public function getAttributes(): array;

    public function getType(): string;

    public function getLayoutNodes(): ?HyperRender;

    public function getRender(): string;

    public function isTemplated(): bool;
}
