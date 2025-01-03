<?php

namespace Stradow\Framework\Render\Interface;

interface RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string;
}
