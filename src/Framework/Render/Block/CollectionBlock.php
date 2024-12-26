<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {

        $CollectionId = $State->getValue();

        $Collection = $Content->getRepo()?->getCollection($CollectionId);

        if (is_null($Collection)) {
            $Collection = new \stdClass;
            $Collection->Contents = [];
        } else {
            $Collection->Contents = $Content->getRepo()->getCollectionContents(
                collectionId: $CollectionId,
                limit: $State->getProperty('limit'),
                offset: $State->getProperty('offset'),
                orderBy: $State->getProperty('orderBy'),
                orderDirection: $State->getProperty('orderDirection'),
                siteUrl: $Content->getConfig('site_url'),
            );
        }

        $template = $State->getProperty('template') ?? $Collection?->properties?->template ?? 'templates/collection.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Content' => $Content,
            'Block' => $State,
            'Collection' => $Collection,
        ]);
    }
}
