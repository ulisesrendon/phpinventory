<?php
namespace Stradow\Blog\Render\Block;

use Stradow\Framework\Validator;
use Stradow\Framework\Database\DataBaseAccess;
use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    private DataBaseAccess $DataBaseAccess;

    public function __construct()
    {
        $this->DataBaseAccess = Container::get(DataBaseAccess::class);
    }

    public function render(NodeContextInterface $context): string
    {
        $blockProperties = $context->getProperties();

        $Collection = $this->DataBaseAccess->select("SELECT 
                collections.id,
                collections.title,
                collections.properties,
                collections.type
                from collections
                where 
                    collections.title = :collection_title
                limit 1
            ",
            [
                'collection_title' => $context->getValue(),
            ]
        );
        $Collection->properties = json_decode($Collection->properties);

        $Contents = $this->DataBaseAccess->query("SELECT 
                contents.id,
                contents.path,
                contents.title,
                contents.properties,
                contents.type
                from contents
                join collections_contents on collections_contents.content_id = contents.id
                where 
                    collections_contents.collection_id = :collection_id
                order by
                    collections_contents.weigth
            ",
            [
                'collection_id' => $Collection->id,
            ]
        );

        foreach($Contents as $Content){
            $Content->properties = json_decode($Content->properties);
            $Content->url = (new Validator($Content->path))->url()->isCorrect() ? $Content->path : "http://phpinventory.test/{$Content->path}";
        }

        return (string) new TemplateRender(CONTENT_DIR."/{$Collection->properties->template}", [
            'Collection' => $Collection,
            'Contents' => $Contents,
        ]);


        // return "<{$tag}{$properties}>{$content}</{$tag}>";
    }
}