<?php
namespace Stradow\Blog\Controller;

use PDO;
use Stradow\Blog\Data\BlogQuery;
use Neuralpin\HTTPRouter\Response;
use Stradow\Blog\Render\HyperItemsRender;
use Stradow\Framework\Database\DataBaseAccess;

class BlogController
{
    private PDO $PDOLite;
    private DataBaseAccess $DataBaseAccess;
    private BlogQuery $BlogQuery;

    public function __construct()
    {
        $this->PDOLite = new PDO('sqlite:'.realpath(__DIR__ . '/../../Database/static.db'));
        $this->PDOLite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->PDOLite->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->DataBaseAccess = new DataBaseAccess($this->PDOLite);
        $this->BlogQuery = new BlogQuery($this->DataBaseAccess);
    }

    public function pageGetById(int $id)
    {

        $items = $this->BlogQuery->getContentById($id);

        if(empty($items)){
            return Response::json([], 404);
        }

        $HyperRender = new HyperItemsRender($items, RENDER_CONFIG);


        // dd($nodesBase);

        return Response::html($HyperRender->render());
    }

}