<?php

namespace Stradow\Framework\Render\Interface;

interface ContentStateInterface
{
    public function getId(): int|float|string;

    public function getPath(): string;

    public function getTitle(): string;

    public function getProperties(): object;

    public function isActive(): bool;

    public function getRepo(): object;

    public function getRoot(): object;

    public function getConfig(?string $name = null): mixed;

    public function setConfig(string $name, mixed $value);

    public function deleteConfig(string $name);
}
