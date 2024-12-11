<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ImgBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        return htmlspecialchars("<img src=\"{$Context->getValue()}\">");
    }
}