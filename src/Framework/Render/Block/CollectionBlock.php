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

        /**
         * @var \Stradow\Framework\Config $Config
         */
        $Config = $Context->getExtra('Config');

        $CollectionId = $Context->getValue();

        $Collection = $ContentRepo?->getCollection($CollectionId);

        if (is_null($Collection)) {
            $Collection = new \stdClass;
            $Collection->Contents = [];
        }else{
            $Collection->Contents = $ContentRepo->getCollectionContents(
                collectionId: $CollectionId, 
                limit: $Context->getProperties('limit'),
                offset: $Context->getProperties('offset'),
                orderBy: $Context->getProperties('orderBy'),
                orderDirection: $Context->getProperties('orderDirection'),
                siteUrl: $Config->get('site_url'),
            );
        }

        $template = $Context->getProperties('template') ?? $Collection?->properties?->template ?? 'templates/collection.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Collection' => $Collection,
        ]);
    }
}
