<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;
use Stradow\Framework\Render\TagRender;

class HeadingBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {
        if ($State->isTemplated()) {
            return (string) new TemplateRender(CONTENT_DIR."/{$State->getProperty('template')}", [
                'BlockState' => $State,
                'GlobalState' => $GlobalState,
                'Config' => $GlobalState->getConfig(),
                'TagRender' => TagRender::class,
                'TemplateRender' => TemplateRender::class,
            ]);
        }

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
