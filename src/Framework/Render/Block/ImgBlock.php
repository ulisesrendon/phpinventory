<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ImgBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        return htmlspecialchars("<img src=\"{$Context->getValue()}\">");
    }
}
