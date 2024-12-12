<?php

namespace Stradow\Framework\Render\Interface;

interface NodeContextInterface
{
    public function getValue();

    public function getId();

    public function getChildren(): array;

    public function getProperties(): array;

    public function getExtra(string $key): mixed;
}
