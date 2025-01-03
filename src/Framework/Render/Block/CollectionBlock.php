<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    private static array $Collections = [];

    private static array $CollectionsContents = [];

    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {

        $CollectionId = $State->getValue();

        self::$Collections[$CollectionId] ??= $GlobalState->getRepo()?->getCollection($CollectionId);

        $Collection = self::$Collections[$CollectionId];

        if (is_null($Collection)) {
            $Collection = new \stdClass;
            $Collection->Contents = [];
        } else {
            self::$CollectionsContents[$CollectionId] ??= $GlobalState->getRepo()->getCollectionContents(
                collectionId: $CollectionId,
                limit: $State->getProperty('limit'),
                offset: $State->getProperty('offset'),
                orderBy: $State->getProperty('orderBy'),
                orderDirection: $State->getProperty('orderDirection'),
                siteUrl: $GlobalState->getConfig('site_url'),
            );

            $Collection->Contents = self::$CollectionsContents[$CollectionId];
        }

        $template = $State->getProperty('template') ?? $Collection?->properties?->template ?? 'templates/collection.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Content' => $GlobalState,
            'Block' => $State,
            'Collection' => $Collection,
        ]);
    }
}
