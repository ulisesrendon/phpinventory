<?php
namespace Stradow\Blog\Render\Block;

use PDO;
use Stradow\Framework\Database\DataBaseAccess;
use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Blog\Render\Interface\NodeContextInterface;
use Stradow\Blog\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    public function render(NodeContextInterface $context): string
    {
        $blockProperties = $context->getProperties();
    
        $DatabaseAccess = Container::get('ContentDataAccess');

        $Collection = $DatabaseAccess->select("SELECT 
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

        $Contents = Container::get('ContentDataAccess')->query("SELECT 
                contents.id,
                contents.path,
                contents.title,
                contents.properties,
                contents.type
                from contents
                join collections_contents on collections_contents.content_id = contents.id
                join collections on collections_contents.collection_id = collections.id
                where 
                    collections.title = :collection_title
                order by
                    collections_contents.weigth
            ",
            [
                'collection_title' => $context->getValue(),
            ]
        );

        foreach($Contents as $Content){
            $Content->properties = json_decode($Content->properties);
        }


        return (string) new TemplateRender(CONTENT_DIR . "/{$Collection->properties->template}", [
            'content' => 'lorem'
        ]);


        // return "<{$tag}{$properties}>{$content}</{$tag}>";
    }
}