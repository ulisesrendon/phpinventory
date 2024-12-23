<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class HeadingBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $tag = $State->getProperty('type');

        $heading = $State->getValue() ?? '';
        $IdFragment = explode('-', $State->getId())[0] ?? '';

        return "<$tag name=\"{$this->getSlug($heading)}-$IdFragment\">{$heading}</$tag>";
    }

    public static function getSlug(string $string): string
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug;
    }
}
