<?php

namespace Stradow\Content\Render\Interface;

interface RendereableInterface
{
    public function render(NodeContextInterface $Context): string;
}
