<?php

namespace Stradow\Framework\Render\Interface;

interface NodeContextInterface
{
    public function getValue();

    public function getId();

    public function getChildren(): array;

    public function getProperties(?string $key = null): mixed;

    public function getExtra(string $key): mixed;
}
