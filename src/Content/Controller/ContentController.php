<?php
namespace Stradow\Content\Controller;

use PDO;
use Stradow\Content\Data\ContentRepo;
use Neuralpin\HTTPRouter\Response;
use Stradow\Content\Render\HyperNode;
use Stradow\Content\Render\HyperItemsRender;
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

        $HyperRender = new HyperItemsRender();

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
                        'tree' => $HyperRender,
                        'repo' => $this->ContentRepo,
                    ],
                )
            );
        }

        return Response::template(
            content: CONTENT_DIR."/templates/page.template.php",
            context: [
                'Content' => $Content,
                'render' => $HyperRender->render(),
            ]
        );
    }

}