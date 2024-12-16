<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        /**
         * @var \Stradow\Content\Data\ContentRepo $ContentRepo
         */
        $ContentRepo = $Context->getExtra('Repo');

        $Collection = $ContentRepo?->getCollection($Context->getValue());

        if (is_null($Collection)) {
            $Collection = new \stdClass;
            $Collection->Contents = [];
        }else{
            $Collection->Contents = $ContentRepo->getCollectionContents($Collection->id);
        }

        $template = $Context->getProperties('template') ?? $Collection?->properties?->template ?? 'templates/collection.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Collection' => $Collection,
        ]);
    }
}
