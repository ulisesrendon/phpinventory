<?php
namespace Stradow\Content\Controller;

use PDO;
use Stradow\Content\Data\ContentQuery;
use Neuralpin\HTTPRouter\Response;
use Stradow\Content\Render\HyperNode;
use Stradow\Content\Render\HyperItemsRender;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

class ContentController
{
    private PDO $PDOLite;
    private DataBaseAccess $DataBaseAccess;
    private ContentQuery $ContentQuery;

    public function __construct()
    {
        $this->DataBaseAccess = Container::get(DataBaseAccess::class);
        $this->ContentQuery = new ContentQuery($this->DataBaseAccess);
    }

    public function get(string $path)
    {

        $Content = $this->ContentQuery->getContentByPath($path);

        if (empty($Content)) {
            return Response::template(PUBLIC_DIR.'/404.html', 404);
        }

        /**
         * @var HyperNode[] $items
         */
        $items = [];

        foreach($Content->nodes as $item){
            $node = new HyperNode();
            $node->setId($item->id);
            $node->setValue($item->value);
            $node->setProperties([
                ...$item->properties,
                'id' => $item->id,
                'type' => $item->type,
            ]);
            $node->setParent($item->parent);
            $node->setRender(new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']));

            $items[] = $node;
        }

        $HyperRender = new HyperItemsRender($items);

        return Response::html($HyperRender->render());
    }

}