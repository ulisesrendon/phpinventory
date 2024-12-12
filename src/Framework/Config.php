<?php

namespace Stradow\Framework;

class Config
{
    private array $config = [];

    public function get(string $name): mixed
    {
        return $this->config[$name] ?? null;
    }

    public function set(string $name, mixed $value): void
    {
        $this->config[$name] = $value;
    }

    public function delete(string $name)
    {
        if (isset($this->config[$name])){
            unset($this->config[$name]);
        }
    }
}
