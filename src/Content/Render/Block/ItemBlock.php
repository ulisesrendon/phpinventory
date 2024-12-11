<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class ItemBlock implements RendereableInterface
{

    public function render(NodeContextInterface $Context): string
    {
        return $Context->getValue();
    }
}

