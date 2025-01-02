<?php

namespace Stradow\Framework\Render\Interface;

interface PrettifierInterface
{
    public function prettify(string $code): string;
}
