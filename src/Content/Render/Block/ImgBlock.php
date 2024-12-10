<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ImgBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        return htmlspecialchars("<img src=\"{$context->getValue()}\">");
    }
}