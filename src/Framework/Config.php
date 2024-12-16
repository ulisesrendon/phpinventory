<?php

namespace Stradow\Framework;

class Config
{
    private array $config = [];

    public function get(?string $name = null): mixed
    {
        return is_null($name) ? $this->config : $this->config[$name] ?? null;
    }

    public function set(string $name, mixed $value): void
    {
        $this->config[$name] = $value;
    }

    public function delete(string $name)
    {
        if (isset($this->config[$name])) {
            unset($this->config[$name]);
        }
    }
}
