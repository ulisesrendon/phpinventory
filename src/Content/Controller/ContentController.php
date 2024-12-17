<?php

namespace Stradow\Content\Controller;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Neuralpin\HTTPRouter\RequestData as Request;
use Neuralpin\HTTPRouter\Response;
use PDO;
use Stradow\Content\Data\ContentRepo;
use Stradow\Content\Event\ContentUpdated;
use Stradow\Framework\Config;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\Database\UpsertHelper;
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
     * Retrieves a content by path
     * @param string $path
     * @return \Neuralpin\HTTPRouter\Interface\ResponseState
     */
    public function get(string $path)
    {

        $Content = $this->ContentRepo->getContentByPath($path);

        if (empty($Content)) {
            return Response::template(PUBLIC_DIR.'/404.html', 404);
        }

        $SiteConfig = Container::get(Config::class);

        $HyperRender = new HyperItemsRender;

        foreach ($Content->nodes as $item) {
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

    public function static()
    {

        $Contents = $this->DataBaseAccess->query("SELECT 
            contents.path
            from contents 
            where 
            contents.active is true
            and type != 'link'
        ");

        $SiteConfig = Container::get(Config::class);

        $staticPath = $SiteConfig->get('staticpath') ?? 'public/static';
        $staticDir = realpath(BASE_DIR."/$staticPath");

        function force_file_put_contents(string $filePath, mixed $data, int $flags = 0)
        {
            $dirPathOnly = dirname($filePath);
            if (! is_dir($dirPathOnly)) {
                mkdir($dirPathOnly, 0775, true);
            }
            file_put_contents($filePath, $data, $flags);
        }

        $created = [];

        foreach ($Contents as $Page) {

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
                filepath: CONTENT_DIR."/$template",
                context: [
                    'Content' => $Content,
                    'Config' => $SiteConfig,
                    'render' => $HyperRender->render(),
                ]
            );

            $extension = pathinfo($Page->path)['extension'] ?? '';

            if (empty($extension)) {
                $Page->path .= '.html';
            }

            force_file_put_contents($staticDir."/{$Page->path}", (string) $Render);

            $created[] = $staticDir."/{$Page->path}";
        }

        return Response::json([
            'contents' => $created,
        ]);
    }

    /**
     * Retrieves a list of contents
     * @return \Neuralpin\HTTPRouter\Interface\ResponseState
     */
    public function listContents()
    {
        $Contents = $this->DataBaseAccess->query('SELECT 
                contents.id,
                contents.path,
                contents.title,
                contents.active,
                contents.type,
                contents.parent,
                contents.weight
            from contents 
        ');

        return Response::json([
            'count' => count($Contents),
            'list' => $Contents,
        ]);
    }

    /**
     * Shows content data by id
     * @param string $id
     * @return \Neuralpin\HTTPRouter\Interface\ResponseState
     */
    public function getContent(string $id)
    {
        $Content = $this->ContentRepo->getContent($id);

        if (empty($Content)) {
            return Response::json((object) [], 404);
        }

        return Response::json($Content);
    }

    /**
     * Retrieves a list of collections
     * @return \Neuralpin\HTTPRouter\Interface\ResponseState
     */
    public function listCollections()
    {
        $Collections = $this->DataBaseAccess->query('SELECT 
                collections.id,
                collections.title,
                collections.type,
                collections.parent,
                collections.weight
            from collections 
        ');

        return Response::json([
            'count' => count($Collections),
            'list' => $Collections,
        ]);
    }

    /**
     * Retrieves collection data by id
     * @param string $id
     * @param \Neuralpin\HTTPRouter\RequestData $Request
     * @return \Neuralpin\HTTPRouter\Interface\ResponseState
     */
    public function getCollection(string $id, Request $Request)
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

        if(!is_null($page) || !is_null($perPage)){
            $page = is_null($page) ? 1 : (int) $page;
            $page = $page < 1 ? 1 : $page;
            $perPage = is_null($perPage) ? 20: (int) $perPage;
            $perPage = $perPage < 1 ? 1 : $perPage;
            $offset = ($page - 1) * $perPage;
        }

        if(!is_null($orderDirection)){
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
     * @param \Neuralpin\HTTPRouter\RequestData $Request
     * @param string $id
     * @return \Neuralpin\HTTPRouter\Interface\ResponseState
     */
    public function updateCollection(Request $Request, string $id)
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
            $UpsertHelper = new UpsertHelper($fields, ['id']);
            $result = $this->DataBaseAccess->command("INSERT INTO collections({$UpsertHelper->columnNames}) values 
                ({$UpsertHelper->allPlaceholders}) 
                ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
            ", $UpsertHelper->parameters);
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

    public function addContentToCollection(Request $Request, string $collection, string $content)
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

    public function removeContentFromCollection(string $collection, string $content)
    {
        $result = $this->ContentRepo->removeContentFromCollection(collection: $collection, content: $content);

        return Response::json([
            'status' => $result,
        ]);
    }

    public function updateContent(Request $Request, string $id)
    {
        $fields = [];
        $errors = [];

        if ((new Validator($id))->uuid()->isCorrect()) {
            $fields['id'] = $id;
        } else {
            $errors[] = 'Invalid collection Id';
        }

        if (!is_null($Request->getInput('path'))) {
            if ((new Validator($Request->getInput('path')))->populated()->string()->isCorrect()) {
                $fields['path'] = $Request->getInput('path');
            } else {
                $errors[] = 'Path cannot be an empty value';
            }
        }

        if (!is_null($Request->getInput('title'))) {
            if ((new Validator($Request->getInput('title')))->populated()->string()->isCorrect()) {
                $fields['title'] = $Request->getInput('title');
            } else {
                $errors[] = 'Title cannot be an empty value';
            }
        }

        if (!is_null($Request->getInput('properties'))) {
            if ((new Validator($Request->getInput('properties')))->array()->isCorrect()) {
                $fields['properties'] = json_encode((object) $Request->getInput('properties'));
            } else {
                $errors[] = 'properties cannot be an empty value';
            }
        }

        if (!is_null($Request->getInput('active'))) {
            if ((new Validator($Request->getInput('active')))->bool()->isCorrect()) {
                $fields['active'] = $Request->getInput('active');
            } else {
                $errors[] = 'active must be a boolean value';
            }
        }

        if (!is_null($Request->getInput('type'))) {
            if ((new Validator($Request->getInput('type')))->populated()->string()->isCorrect()) {
                $fields['type'] = $Request->getInput('type');
            } else {
                $errors[] = 'Type cannot be an empty value';
            }
        }

        if (!is_null($Request->getInput('parent'))) {
            if ((new Validator($Request->getInput('parent')))->uuid()->isCorrect()) {
                $fields['parent'] = $Request->getInput('parent');
            } else {
                $errors[] = 'Invalid parent Id';
            }
        }

        if (!is_null($Request->getInput('weight'))) {
            if ((new Validator($Request->getInput('weight')))->int()->min(0)->isCorrect()) {
                $fields['weight'] = $Request->getInput('weight');
            } else {
                $errors[] = 'weight cannot be an empty value';
            }
        }

        $removeNodes = null;
        if (!is_null($Request->getInput('removeNodes'))) {
            if ((new Validator($Request->getInput('removeNodes')))->array()->isCorrect()) {
                $removeNodes = $Request->getInput('removeNodes');
            } else {
                $errors[] = 'removeNodes must be an array';
            }
        }

        $nodesToAdd = [];
        if (!is_null($Request->getInput('nodes'))) {
            if ((new Validator($Request->getInput('nodes')))->array()->isCorrect()) {
                $nodesToAdd = $Request->getInput('nodes');
            } else {
                $errors[] = 'nodes must be an array';
            }
        }

        if (!empty($errors)) {
            return Response::json([
                'error' => $errors,
            ], 400);
        }

        $result = true;
        if (count($fields) > 1) {
            $UpsertHelper = new UpsertHelper($fields, ['id']);
            $result = $this->DataBaseAccess->command(
                query: "INSERT INTO contents({$UpsertHelper->columnNames}) 
                        values ({$UpsertHelper->allPlaceholders}) 
                        ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
                    ",
                params: $UpsertHelper->parameters
            );
        }

        if ($result && !empty($nodesToAdd)) {
            $nodeErrors = [];
            foreach ($nodesToAdd as $k => $node) {
                $nodesToAdd[$k]['content'] = $fields['id'];

                if(isset($node['properties'])){
                    $nodesToAdd[$k]['properties'] = json_encode((object) $node['properties']);
                }
            }

            foreach ($nodesToAdd as $node) {
                $UpsertHelper = new UpsertHelper($node, ['id']);
                $this->DataBaseAccess->command(
                    query: "INSERT INTO contentnodes({$UpsertHelper->columnNames}) 
                        values ({$UpsertHelper->allPlaceholders}) 
                        ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
                    ",
                    params: $UpsertHelper->parameters
                );
            }
        }

        if ($result && !empty($removeNodes)) {
            $this->ContentRepo->deleteNodes($removeNodes);
        }

        if (!empty($nodesToAdd)) {
            $fields['nodes'] = $nodesToAdd;
        }
        if (!empty($removeNodes)) {
            $fields['removeNodes'] = $removeNodes;
        }

        if ($result || !empty($nodesToAdd)) {
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

    public function deleteContent()
    {
        return Response::json([]);
    }
}
