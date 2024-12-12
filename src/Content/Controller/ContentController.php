<?php

namespace Stradow\Content\Controller;

use PDO;
use Stradow\Framework\Config;
use Neuralpin\HTTPRouter\Response;
use Stradow\Content\Data\ContentRepo;
use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Render\HyperItemsRender;
use Stradow\Framework\Config\Data\ConfigRepo;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

class ContentController
{
    private PDO $PDOLite;

    private DataBaseAccess $DataBaseAccess;

    private ContentRepo $ContentRepo;

    public function __construct()
    {
        $this->DataBaseAccess = Container::get(DataBaseAccess::class);
        $this->ContentRepo = new ContentRepo($this->DataBaseAccess);
    }

    public function get(string $path)
    {

        $Content = $this->ContentRepo->getContentByPath($path);

        if (empty($Content)) {
            return Response::template(PUBLIC_DIR.'/404.html', 404);
        }

        $ConfigRepo = (new ConfigRepo($this->DataBaseAccess))->getConfigAll();
        $SiteConfig = new Config;
        foreach($ConfigRepo as $Config){
            $SiteConfig->set($Config->name, $Config->value);
        }

        $HyperRender = new HyperItemsRender;

        foreach ($Content->nodes as $item) {
            $HyperRender->addNode(
                id: $item->id,
                node: new HyperNode(
                    id: $item->id,
                    value: $item->value,
                    properties: $item->properties,
                    type: $item->type,
                    parent: $item->parent,
                    RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                    context: [
                        'Tree' => $HyperRender,
                        'Repo' => $this->ContentRepo,
                        'Config' => $SiteConfig,
                    ],
                )
            );
        }

        $template = $Content?->properties?->template ?? 'templates/page.template.php';

        return Response::template(
            content: CONTENT_DIR."/$template",
            context: [
                'Content' => $Content,
                'Config' => $SiteConfig,
                'render' => $HyperRender->render(),
            ]
        );
    }
}
