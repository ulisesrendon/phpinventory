<?php

namespace Stradow\Framework\Render\Interface;

interface RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string;
}
