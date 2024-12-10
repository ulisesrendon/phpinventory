<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\RendereableInterface;
use Stradow\Content\Render\Interface\NodeContextInterface;

class DefaultBlock implements RendereableInterface
{

    public function render(NodeContextInterface $context): string
    {
        $children = [];
        foreach($context->getChildren() as $item){
            $children[] = [
                'type' => htmlspecialchars($item->getProperties()['type']),
                'value' => htmlspecialchars($item->getValue()),
                'children' => $item->getChildren(),
            ];
        }

        return '<pre><code>'.json_encode([
            // 'id' => htmlspecialchars($context->getId()),
            'type' => htmlspecialchars($context->getProperties()['type']),
            'value' => htmlspecialchars($context->getValue()),
            'children' => $children,
        ]).'</code></pre>';
    }
}