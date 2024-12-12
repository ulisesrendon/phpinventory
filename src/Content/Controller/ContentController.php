<?php

namespace Stradow\Content\Controller;

use PDO;
use Stradow\Framework\Config;
use Neuralpin\HTTPRouter\Response;
use Stradow\Content\Data\ContentRepo;
use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Config\Data\ConfigRepo;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\Render\HyperItemsRender;
use Neuralpin\HTTPRouter\Helper\TemplateRender;
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

    public function static()
    {

        $Contents = $this->DataBaseAccess->query("SELECT 
            contents.path
            from contents 
            join collections_contents on collections_contents.content_id = contents.id
            join collections on collections.id = collections_contents.collection_id 
            where 
            contents.active is true
            and collections.title = 'main-content'
        ");

        $ConfigRepo = (new ConfigRepo($this->DataBaseAccess))->getConfigAll();
        $SiteConfig = new Config;
        foreach ($ConfigRepo as $Config) {
            $SiteConfig->set($Config->name, $Config->value);
        }

        $cacheDir = BASE_DIR.'/../static';

        function force_file_put_contents(string $filePath, mixed $data, int $flags = 0)
        {
            $dirPathOnly = dirname($filePath);
            if (!is_dir($dirPathOnly)) {
                mkdir($dirPathOnly, 0775, true);
            }
            file_put_contents($filePath, $data, $flags);
        }

        $created = [];

        foreach($Contents as $Page){

            $Content = $this->ContentRepo->getContentByPath($Page->path);

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

            $Render = new TemplateRender(
                filepath: CONTENT_DIR . "/$template",
                context: [
                    'Content' => $Content,
                    'Config' => $SiteConfig,
                    'render' => $HyperRender->render(),
                ]
            );

            force_file_put_contents($cacheDir."/{$Page->path}", (string) $Render);

            // $pathinfo = pathinfo('/www/htdocs/inc/lib.inc.php');

            $created[] = $cacheDir."/{$Page->path}";
        }

        return Response::json([
            'contents' => $created,
        ]);
    }
}
