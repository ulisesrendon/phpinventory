<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class HeadingBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $heading = $State->getValue() ?? '';

        $attributes = $State->getAttributes();
        $attributes['name'] ??= $this->generateName($heading, $State->getId());

        return (string) new TagRender(
            tag: $State->getProperty('type') ?? 'h1',
            attributes: $attributes,
            content: $heading,
            isEmpty: false,
        );
    }

    public function getSlug(string $string): string
    {
        return preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    }

    public function generateName(string $text, $id)
    {
        $text = strtolower($text);
        $IdFragment = explode('-', $id)[0] ?? '';

        return "{$this->getSlug($text)}-$IdFragment";
    }
}
