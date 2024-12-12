<?php

namespace Stradow\Content\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        /**
         * @var \Stradow\Content\Data\ContentRepo $ContentRepo
         */
        $ContentRepo = $Context->getExtra('repo');

        $Collection = $ContentRepo?->getCollectionByTitle($Context->getValue());

        if(is_null($Collection)){
            $Collection = new \stdClass;
            $Collection->Contents = [];
        }

        $template = $Context->getProperties()['template'] ?? $Collection?->properties?->template ?? 'templates/collection.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Collection' => $Collection,
        ]);
    }
}
