<?php
namespace Stradow\Blog\Render\Block;

use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class ImgBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        return htmlspecialchars("<img src=\"{$context->getValue()}\">");
    }
}