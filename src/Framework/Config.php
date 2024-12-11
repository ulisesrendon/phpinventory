<?php

namespace Stradow\Framework;

class Config
{
    private static array $config = [];

    public static function get(string $key): mixed
    {
        return self::$config[$key] ?? null;
    }

    public static function set(string $key, mixed $value): void
    {
        self::$config[$key] = $value;
    }
}
