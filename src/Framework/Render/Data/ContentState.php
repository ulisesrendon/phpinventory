<?php

namespace Stradow\Framework\Render\Data;

use Stradow\Framework\Render\Interface\ContentStateInterface;

class ContentState implements ContentStateInterface
{
    private array $config = [];
    private array $renderConfig = [];

    private $id;

    private ?string $path;

    private string $title;

    private object $properties;

    private bool $active;

    private string $type;

    private object $Root;

    private object $Repo;

    public function __construct(
        int|float|string $id,
        string $title,
        object $properties,
        bool $active,
        string $type,
        object $Root,
        object $Repo,
        array $config,
        array $renderConfig,
        ?string $path = null,
    ) {
        $this->id = $id;
        $this->path = $path;
        $this->title = $title;
        $this->properties = $properties;
        $this->active = $active;
        $this->type = $type;
        $this->Root = $Root;
        $this->Repo = $Repo;
        $this->config = $config;
        $this->renderConfig = $renderConfig;
    }

    public function getId(): float|int|string
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getProperties(): object
    {
        return $this->properties;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getRoot(): object
    {
        return $this->Root;
    }

    public function getRepo(): object
    {
        return $this->Repo;
    }

    public function getRenderConfig(): array
    {
        return $this->renderConfig;
    }

    public function getConfig(?string $name = null): mixed
    {
        return is_null($name) ? $this->config : $this->config[$name] ?? null;
    }

    public function setConfig(string $name, mixed $value): void
    {
        $this->config[$name] = $value;
    }

    public function deleteConfig(string $name)
    {
        if (isset($this->config[$name])) {
            unset($this->config[$name]);
        }
    }
}
