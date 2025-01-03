<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class DefaultBlock implements RendereableInterface
{
    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {

        $children = [];
        foreach ($State->getChildren() as $item) {
            $children[] = [
                'type' => htmlspecialchars($item->getProperty('type')),
                'value' => htmlspecialchars($item->getValue()),
                'children' => $item->getChildren(),
            ];
        }

        return '<pre><code>'.json_encode([
            // 'id' => htmlspecialchars($context->getId()),
            'type' => htmlspecialchars($State->getProperty('type')),
            'value' => htmlspecialchars($State->getValue()),
            'children' => $children,
        ]).'</code></pre>';
    }
}
