<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ArticlePrevNextBlock implements RendereableInterface
{
    private static array $Contents = [];

    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {
        self::$Contents[$State->getValue()] ??= $GlobalState->getRepo()->getCollectionContents(
            collectionId: $State->getValue(),
            orderBy: $State->getProperty('orderBy'),
            orderDirection: $State->getProperty('orderDirection'),
            siteUrl: $GlobalState->getConfig('site_url'),
        );

        $Contents = self::$Contents[$State->getValue()];

        $actualIndex = null;
        foreach ($Contents as $k => $Item) {
            if ($Item->id == $GlobalState->getId()) {
                $actualIndex = $k;
                break;
            }
        }

        $PrevContent = $Contents[$actualIndex - 1] ?? null;
        $NextContent = $Contents[$actualIndex + 1] ?? null;
        $ActualContent = $Contents[$actualIndex] ?? null;

        $template = $State->getProperty('template') ?? 'templates/ArticlePrevNextBlock.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Content' => $GlobalState,
            'Block' => $State,
            'ActualContent' => $ActualContent,
            'PrevContent' => $ActualContent ? $PrevContent : null,
            'NextContent' => $ActualContent ? $NextContent : null,
        ]);
    }
}
