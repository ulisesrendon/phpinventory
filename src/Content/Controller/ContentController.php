<?php

namespace Stradow\Content\Controller;

use Neuralpin\HTTPRouter\Interface\ResponseState;
use Neuralpin\HTTPRouter\RequestData as Request;
use Neuralpin\HTTPRouter\Response;
use PDO;
use Stradow\Content\Data\ContentRepo;
use Stradow\Content\Event\ContentUpdated;
use Stradow\Framework\Config;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Event\Event;
use Stradow\Framework\Render\HyperItemsRender;
use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Validator;

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

    /**
     * Retrieves content by path
     */
    public function get(string $path): ResponseState
    {

        $Content = $this->ContentRepo->getContentByPath($path);

        if (empty($Content)) {
            return Response::template(PUBLIC_DIR.'/404.html', 404);
        }

        $SiteConfig = Container::get(Config::class);

        $ContentNodes = $this->ContentRepo->getContentNodes($Content->id);
        $HyperRender = new HyperItemsRender;
        foreach ($ContentNodes as $item) {
            $Node = new HyperNode(
                id: $item->id,
                value: $item->value,
                properties: $item->properties,
                type: $item->type ?? 'default',
                parent: $item->parent,
                RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                context: [
                    'Content' => $Content,
                    'Repo' => $this->ContentRepo,
                    'Config' => $SiteConfig,
                ],
            );
            $Node->setRoot($HyperRender);
            $HyperRender->addNode(
                id: $item->id,
                node: new HyperNode(
                    id: $item->id,
                    value: $item->value,
                    properties: $item->properties,
                    type: $item->type ?? 'default',
                    parent: $item->parent,
                    RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                    context: [
                        'Content' => $Content,
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
                'render' => $HyperRender->render($Content->properties->prettify ?? true),
            ]
        );
    }

    /**
     * Retrieves a list of contents
     */
    public function listContents(): ResponseState
    {
        $Contents = $this->ContentRepo->getContentList();

        return Response::json([
            'count' => count($Contents),
            'list' => $Contents,
        ]);
    }

    /**
     * Shows content data by id
     */
    public function getContent(string $id): ResponseState
    {
        $Content = $this->ContentRepo->getContent($id);

        if (empty($Content)) {
            return Response::json((object) [], 404);
        }

        $Content->nodes = $this->ContentRepo->getContentNodes($Content->id);

        return Response::json($Content);
    }

    /**
     * Retrieves a list of collections
     */
    public function listCollections(): ResponseState
    {
        $Collections = $this->ContentRepo->getCollectionList();

        return Response::json([
            'count' => count($Collections),
            'list' => $Collections,
        ]);
    }

    /**
     * Retrieves collection data by id
     */
    public function getCollection(string $id, Request $Request): ResponseState
    {
        $Collection = $this->ContentRepo->getCollection($id);

        if (empty($Collection)) {
            return Response::json((object) [], 404);
        }

        $page = $Request->getParam('page');
        $perPage = $Request->getParam('perpage');
        $offset = null;
        $orderDirection = $Request->getParam('orderdirection');
        $orderBy = $Request->getParam('orderby');

        if (! is_null($page) || ! is_null($perPage)) {
            $page = is_null($page) ? 1 : (int) $page;
            $page = $page < 1 ? 1 : $page;
            $perPage = is_null($perPage) ? 20 : (int) $perPage;
            $perPage = $perPage < 1 ? 1 : $perPage;
            $offset = ($page - 1) * $perPage;
        }

        if (! is_null($orderDirection)) {
            $orderDirection = strtolower($orderDirection);
            if ($orderDirection != 'asc' && $orderDirection != 'desc') {
                $orderDirection = 'asc';
            }
        }

        $Collection->Contents = $this->ContentRepo->getCollectionContents(
            collectionId: $Collection->id,
            siteUrl: Container::get(Config::class)->get('site_url'),
            limit: $perPage,
            offset: $offset,
            orderDirection: $orderDirection,
            orderBy: $orderBy,
        );

        return Response::json($Collection);
    }

    /**
     * Update and creation of collection
     */
    public function updateCollection(Request $Request, string $id): ResponseState
    {
        $fields = [];
        $errors = [];

        if ((new Validator($id))->uuid()->isCorrect()) {
            $fields['id'] = $id;
        } else {
            $errors[] = 'Invalid collection Id';
        }

        if (! is_null($Request->getInput('title'))) {
            if ((new Validator($Request->getInput('title')))->populated()->string()->isCorrect()) {
                $fields['title'] = $Request->getInput('title');
            } else {
                $errors[] = 'Title cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('type'))) {
            if ((new Validator($Request->getInput('type')))->populated()->string()->isCorrect()) {
                $fields['type'] = $Request->getInput('type');
            } else {
                $errors[] = 'Type cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('weight'))) {
            if ((new Validator($Request->getInput('weight')))->int()->min(0)->isCorrect()) {
                $fields['weight'] = json_encode($Request->getInput('weight'));
            } else {
                $errors[] = 'weight cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('properties'))) {
            if ((new Validator($Request->getInput('properties')))->array()->isCorrect()) {
                $fields['properties'] = json_encode($Request->getInput('properties'));
            } else {
                $errors[] = 'properties cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('parent'))) {
            if ((new Validator($Request->getInput('parent')))->uuid()->isCorrect()) {
                $fields['parent'] = $Request->getInput('parent');
            } else {
                $errors[] = 'Invalid parent Id';
            }
        }

        if (! empty($errors)) {
            return Response::json([
                'error' => $errors,
            ], 400);
        }

        $result = false;
        if (count($fields) > 1) {
            $result = $this->ContentRepo->saveCollection($fields);
        }

        if ($result) {
            return Response::json([
                'updated' => $fields,
            ]);
        } else {
            return Response::json([
                'error' => 'No data provided',
            ], 400);
        }

    }

    public function addContentToCollection(Request $Request, string $collection, string $content): ResponseState
    {

        $ContentExists = $this->ContentRepo->getContentExists($content);
        $CollectionExists = $this->ContentRepo->getCollectionExists($collection);

        if (! $ContentExists || ! $CollectionExists) {
            return Response::json([
                'error' => 'content cannot be added to desired collection',
            ], 401);
        }

        $result = $this->ContentRepo->addContentToCollection(collection: $collection, content: $content);

        return Response::json([
            'status' => $result,
        ]);
    }

    public function removeContentFromCollection(string $collection, string $content): ResponseState
    {
        $result = $this->ContentRepo->removeContentFromCollection(collection: $collection, content: $content);

        return Response::json([
            'status' => $result,
        ]);
    }

    public function updateContent(Request $Request, string $id): ResponseState
    {
        $fields = [];
        $errors = [];

        if ((new Validator($id))->uuid()->isCorrect()) {
            $fields['id'] = $id;
        } else {
            $errors[] = 'Invalid collection Id';
        }

        if (! is_null($Request->getInput('path'))) {
            if ((new Validator($Request->getInput('path')))->populated()->string()->isCorrect()) {
                $fields['path'] = $Request->getInput('path');
            } else {
                $errors[] = 'Path cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('title'))) {
            if ((new Validator($Request->getInput('title')))->populated()->string()->isCorrect()) {
                $fields['title'] = $Request->getInput('title');
            } else {
                $errors[] = 'Title cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('properties'))) {
            if ((new Validator($Request->getInput('properties')))->array()->isCorrect()) {
                $fields['properties'] = json_encode((object) $Request->getInput('properties'));
            } else {
                $errors[] = 'properties cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('active'))) {
            if ((new Validator($Request->getInput('active')))->bool()->isCorrect()) {
                $fields['active'] = $Request->getInput('active');
            } else {
                $errors[] = 'active must be a boolean value';
            }
        }

        if (! is_null($Request->getInput('type'))) {
            if ((new Validator($Request->getInput('type')))->populated()->string()->isCorrect()) {
                $fields['type'] = $Request->getInput('type');
            } else {
                $errors[] = 'Type cannot be an empty value';
            }
        }

        if (! is_null($Request->getInput('parent'))) {
            if ((new Validator($Request->getInput('parent')))->uuid()->isCorrect()) {
                $fields['parent'] = $Request->getInput('parent');
            } else {
                $errors[] = 'Invalid parent Id';
            }
        }

        if (! is_null($Request->getInput('weight'))) {
            if ((new Validator($Request->getInput('weight')))->int()->min(0)->isCorrect()) {
                $fields['weight'] = $Request->getInput('weight');
            } else {
                $errors[] = 'weight cannot be an empty value';
            }
        }

        $removeNodes = null;
        if (! is_null($Request->getInput('removeNodes'))) {
            if ((new Validator($Request->getInput('removeNodes')))->array()->isCorrect()) {
                $removeNodes = $Request->getInput('removeNodes');
            } else {
                $errors[] = 'removeNodes must be an array';
            }
        }

        $nodesToAdd = [];
        if (! is_null($Request->getInput('nodes'))) {
            if ((new Validator($Request->getInput('nodes')))->array()->isCorrect()) {
                $nodesToAdd = $Request->getInput('nodes');
            } else {
                $errors[] = 'nodes must be an array';
            }
        }

        if (! empty($errors)) {
            return Response::json([
                'error' => $errors,
            ], 400);
        }

        $result = true;
        if (count($fields) > 1) {
            $result = $this->ContentRepo->saveContent($fields);
        }

        if ($result && ! empty($nodesToAdd)) {
            $nodeErrors = [];
            foreach ($nodesToAdd as $k => $node) {
                $nodesToAdd[$k]['content'] = $fields['id'];

                if (isset($node['properties'])) {
                    $nodesToAdd[$k]['properties'] = json_encode((object) $node['properties']);
                }
            }

            $this->ContentRepo->saveContentNodes($nodesToAdd);
        }

        if ($result && ! empty($removeNodes)) {
            $this->ContentRepo->deleteNodes($removeNodes);
        }

        if (! empty($nodesToAdd)) {
            $fields['nodes'] = $nodesToAdd;
        }
        if (! empty($removeNodes)) {
            $fields['removeNodes'] = $removeNodes;
        }

        if ($result || ! empty($nodesToAdd)) {
            Event::dispatch(new ContentUpdated([
                'id' => $id,
            ]));

            return Response::json([
                'updated' => $fields,
            ]);
        } else {
            return Response::json([
                'error' => 'No data provided',
            ], 400);
        }

    }

    public function deleteContent(): ResponseState
    {
        return Response::json([]);
    }
}
