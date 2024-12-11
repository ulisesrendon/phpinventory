<?php
namespace Stradow\Content\Render\Block;

use Stradow\Content\Render\Interface\RendereableInterface;
use Stradow\Content\Render\Interface\NodeContextInterface;

class DefaultBlock implements RendereableInterface
{

    public function render(NodeContextInterface $Context): string
    {
        $children = [];
        foreach($Context->getChildren() as $item){
            $children[] = [
                'type' => htmlspecialchars($item->getProperties()['type']),
                'value' => htmlspecialchars($item->getValue()),
                'children' => $item->getChildren(),
            ];
        }

        return '<pre><code>'.json_encode([
            // 'id' => htmlspecialchars($context->getId()),
            'type' => htmlspecialchars($Context->getProperties()['type']),
            'value' => htmlspecialchars($Context->getValue()),
            'children' => $children,
        ]).'</code></pre>';
    }
}