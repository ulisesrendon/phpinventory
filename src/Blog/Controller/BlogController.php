<?php
namespace Stradow\Blog\Controller;

use PDO;
use Stradow\Blog\Data\BlogQuery;
use Neuralpin\HTTPRouter\Response;
use Stradow\Blog\Render\HyperNode;
use Stradow\Blog\Render\HyperItemsRender;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;

class BlogController
{
    private PDO $PDOLite;
    private DataBaseAccess $DataBaseAccess;
    private BlogQuery $BlogQuery;

    public function __construct()
    {
        $this->DataBaseAccess = Container::get(DataBaseAccess::class);
        $this->BlogQuery = new BlogQuery($this->DataBaseAccess);
    }

    public function pageGetById(string $id)
    {

        $itemsData = $this->BlogQuery->getContentById($id);

        if (empty($itemsData)) {
            return Response::json([], 404);
        }

        /**
         * @var HyperNode[] $items
         */
        $items = [];

        foreach($itemsData as $item){
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