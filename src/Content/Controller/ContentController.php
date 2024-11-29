<?php

namespace Stradow\Content\Controller;

use Stradow\Framework\Validator;
use Neuralpin\HTTPRouter\Response;
use Stradow\Framework\Event\Event;
use Neuralpin\HTTPRouter\RequestData;
use Stradow\Content\Data\ContentQuery;
use Stradow\Content\Data\ContentCommand;
use Stradow\Framework\HTTP\DefaultController;
use Neuralpin\HTTPRouter\Interface\ResponseState;

class ContentController extends DefaultController
{
    private readonly ContentQuery $ContentQuery;

    private readonly ContentCommand $ContentCommand;

    public function __construct()
    {
        parent::__construct();
        
        $this->ContentQuery = new ContentQuery($this->DataBaseAccess);
        $this->ContentCommand = new ContentCommand($this->DataBaseAccess);
    }

    public function list(): ResponseState
    {
        $contents = $this->ContentQuery->list();

        return Response::json([
            'count' => count($contents),
            'list' => $contents,
        ]);
    }

    public function find(int $id): ResponseState
    {
        $content = $this->ContentQuery->getById($id);

        if (empty($content)) {
            return Response::json([], 404);
        }

        $content->body = json_decode($content->body);
        $content->config = json_decode($content->config);

        return Response::json($content);
    }

    public function fieldList(): ResponseState
    {
        $list = $this->ContentQuery->fieldList();

        foreach($list as $item){
            $item->config = json_decode($item->config);
        }

        return Response::json([
            'count' => count($list),
            'list' => $list
        ]);
    }

    public function typeList(): ResponseState
    {
        $list = $this->ContentQuery->typeList();

        foreach ($list as $item) {
            $item->config = json_decode($item->config);
        }

        return Response::json([
            'count' => count($list),
            'list' => $list
        ]);
    }


}
