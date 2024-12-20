<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class ArticlePrevNextBlock implements RendereableInterface
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

        $Contents = $ContentRepo->getCollectionContents(
            collectionId: $Context->getValue(),
            orderBy: $Context->getProperties('orderBy'),
            orderDirection: $Context->getProperties('orderDirection'),
            siteUrl: $Config->get('site_url'),
        );

        $ContentId = $Context->getExtra('Content')?->id;

        $actualIndex = null;
        foreach ($Contents as $k => $Content) {
            if ($Content->id == $ContentId) {
                $actualIndex = $k;
                break;
            }
        }

        $PrevContent = $Contents[$actualIndex - 1] ?? null;
        $NextContent = $Contents[$actualIndex + 1] ?? null;
        $ActualContent = $Contents[$actualIndex] ?? null;

        $template = $Context->getProperties('template') ?? 'templates/ArticlePrevNextBlock.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'ActualContent' => $ActualContent,
            'PrevContent' => $ActualContent ? $PrevContent : null,
            'NextContent' => $ActualContent ? $NextContent : null,
        ]);
    }
}
