<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class HeadingBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        $tag = $Context->getProperties('type');

        $heading = $Context->getValue() ?? '';
        $IdFragment = explode('-', $Context->getId())[0] ?? '';

        return "<$tag name=\"{$this->getSlug($heading)}-$IdFragment\">{$heading}</$tag>";
    }

    public static function getSlug(string $string): string
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug;
    }
}
