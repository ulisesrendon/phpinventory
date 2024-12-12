<?php

namespace Stradow\Framework\Render\Interface;

interface RendereableInterface
{
    public function render(NodeContextInterface $Context): string;
}
