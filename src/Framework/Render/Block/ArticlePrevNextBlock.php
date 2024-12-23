<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ArticlePrevNextBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $Contents = $Content->getRepo()->getCollectionContents(
            collectionId: $State->getValue(),
            orderBy: $State->getProperty('orderBy'),
            orderDirection: $State->getProperty('orderDirection'),
            siteUrl: $Content->getConfig('site_url'),
        );

        $actualIndex = null;
        foreach ($Contents as $k => $Item) {
            if ($Item->id == $Content->getId()) {
                $actualIndex = $k;
                break;
            }
        }

        $PrevContent = $Contents[$actualIndex - 1] ?? null;
        $NextContent = $Contents[$actualIndex + 1] ?? null;
        $ActualContent = $Contents[$actualIndex] ?? null;

        $template = $State->getProperty('template') ?? 'templates/ArticlePrevNextBlock.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'ActualContent' => $ActualContent,
            'PrevContent' => $ActualContent ? $PrevContent : null,
            'NextContent' => $ActualContent ? $NextContent : null,
        ]);
    }
}
