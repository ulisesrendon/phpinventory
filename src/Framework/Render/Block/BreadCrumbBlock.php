<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class BreadCrumbBlock implements RendereableInterface
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

        $CollectionPath = [
            "<a href=\"{$Config->get('site_url')}/{$Context->getExtra('Content')->path}\">Collection 1</a>",
            "<a href=\"{$Config->get('site_url')}/{$Context->getExtra('Content')->path}\">Collection 2</a>",
        ];

        $BreadCrumb = [
            "<a href=\"{$Config->get('site_url')}/{$Context->getExtra('Content')->path}\">Inicio</a>",
            ...$CollectionPath,
            "<span>{$Context->getExtra('Content')->title}</span>",
        ];

        dd($BreadCrumb);

        $template = $Context->getProperties('template') ?? 'templates/ArticlePrevNextBlock.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'BreadCrumb' => $BreadCrumb,
        ]);
    }
}
