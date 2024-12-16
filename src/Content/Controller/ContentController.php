<?php

namespace Stradow\Content\Controller;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Neuralpin\HTTPRouter\RequestData as Request;
use Neuralpin\HTTPRouter\Response;
use PDO;
use Stradow\Content\Data\ContentRepo;
use Stradow\Framework\Config;
use Stradow\Framework\Config\Data\ConfigRepo;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\Database\UpsertHelper;
use Stradow\Framework\DependencyResolver\Container;
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

    public function get(string $path)
    {

        $Content = $this->ContentRepo->getContentByPath($path);

        if (empty($Content)) {
            return Response::template(PUBLIC_DIR.'/404.html', 404);
        }

        $ConfigRepo = (new ConfigRepo($this->DataBaseAccess))->getConfigAll();
        $SiteConfig = new Config;
        foreach ($ConfigRepo as $Config) {
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

            force_file_put_contents($cacheDir."/{$Page->path}", (string) $Render);

            // $pathinfo = pathinfo('/www/htdocs/inc/lib.inc.php');

            $created[] = $cacheDir."/{$Page->path}";
        }

        return Response::json([
            'contents' => $created,
        ]);
    }

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

    public function getContent(string $id)
    {
        $Content = $this->ContentRepo->getContent($id);

        if (empty($Content)) {
            return Response::json((object) [], 404);
        }

        return Response::json($Content);
    }

    public function updateContent()
    {
        return Response::json([]);
    }

    public function deleteContent()
    {
        return Response::json([]);
    }

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

    public function getCollection(string $id)
    {
        $Collection = $this->ContentRepo->getCollection($id);

        if (empty($Collection)) {
            return Response::json((object) [], 404);
        }

        return Response::json($Collection);
    }

    public function updateCollection(Request $Request, string $id)
    {
        $fields = [];
        $errors = [];

        if ((new Validator($id))->uuid()->isCorrect()) {
            $fields['id'] = $id;
        }else{
            $errors[] = 'Invalid collection Id';
        }

        if(!is_null($Request->getInput('title'))){
            if ((new Validator($Request->getInput('title')))->populated()->string()->isCorrect()) {
                $fields['title'] = $Request->getInput('title');
            }else{
                $errors[] = 'Title cannot be an empty value';
            }
        }

        if(!is_null($Request->getInput('type'))){
            if ((new Validator($Request->getInput('type')))->populated()->string()->isCorrect()) {
                $fields['type'] = $Request->getInput('type');
            }else{
                $errors[] = 'Type cannot be an empty value';
            }
        }

        if(!is_null($Request->getInput('weight'))){
            if ((new Validator($Request->getInput('weight')))->int()->min(0)->isCorrect()) {
                $fields['weight'] = json_encode($Request->getInput('weight'));
            }else{
                $errors[] = 'weight cannot be an empty value';
            }
        }

        if(!is_null($Request->getInput('properties'))){
            if ((new Validator($Request->getInput('properties')))->array()->isCorrect()) {
                $fields['properties'] = json_encode($Request->getInput('properties'));
            }else{
                $errors[] = 'properties cannot be an empty value';
            }
        }

        if(!is_null($Request->getInput('parent'))){
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
        if(count($fields)>1){
            $UpsertHelper = new UpsertHelper($fields, ['id']);
            $result = $this->DataBaseAccess->command("INSERT INTO collections({$UpsertHelper->columnNames}) values 
                ({$UpsertHelper->allPlaceholders}) 
                ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
            ", $UpsertHelper->parameters);
        }

        if($result){
            return Response::json([
                'updated' => $fields,
            ]);
        }else{
            return Response::json([
                'error' => 'No data provided',
            ], 400);
        }

    }

    public function addContentToCollection(Request $Request, string $collection, string $content)
    {

        $ContentExists = $this->ContentRepo->getContentExists($content);
        $CollectionExists = $this->ContentRepo->getCollectionExists($collection);

        if(!$ContentExists || !$CollectionExists){
            return Response::json([
                'error' => 'content cannot be added to desired collection'
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

    public function renderContentNode() {}
}
