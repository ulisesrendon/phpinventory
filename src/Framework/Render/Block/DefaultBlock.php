<?php

namespace Stradow\Framework\Render\Block;

use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class DefaultBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {

        $children = [];
        foreach ($Context->getChildren() as $item) {
            $children[] = [
                'type' => htmlspecialchars($item->getProperties('type')),
                'value' => htmlspecialchars($item->getValue()),
                'children' => $item->getChildren(),
            ];
        }

        return '<pre><code>'.json_encode([
            // 'id' => htmlspecialchars($context->getId()),
            'type' => htmlspecialchars($Context->getProperties('type')),
            'value' => htmlspecialchars($Context->getValue()),
            'children' => $children,
        ]).'</code></pre>';
    }
}
