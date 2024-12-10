<?php

namespace Stradow\Content\Data;

use Stradow\Framework\Database\DataBaseAccess;

class ContentQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getContentQuery(string $extraParts = ''): string
    {
        return "SELECT 
                id,
                parent,
                value,
                properties,
                weigth,
                type
            from contentnodes
            $extraParts
            order by parent, weigth
        ";
    }

    public function getContentById(string $id): ?array
    {
        $items = $this->DataBaseAccess->query($this->getContentQuery('where content = :id'), ['id' => $id]);

        foreach($items as $item){
            $item->properties = json_decode($item->properties, true);
        }
        return $items;
    }

    public function getContentByPath(string $path): ?object
    {
        $Content = $this->DataBaseAccess->select("SELECT id, path, title, properties, active, type from contents where path = :path ", ['path' => $path]);

        if(is_null($Content)){
            return null;
        }

        $items = $this->DataBaseAccess->query($this->getContentQuery('where content = :id'), ['id' => $Content->id]);

        foreach($items as $item){
            $item->properties = json_decode($item->properties, true);
        }

        $Content->properties = json_decode($Content->properties);
        $Content->nodes = $items;

        return $Content;
    }

    public function getCollection($context): object|null
    {
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
                contents.type
                from contents
                join collections_contents on collection
                contents.title,
                contents.properties,s_contents.content_id = contents.id
                where 
                    collections_contents.collection_id = :collection_id
                order by
                    collections_contents.weigth
            ",
            [
                'collection_id' => $Collection->id,
            ]
        );

        $Collection->Contents = $Contents;

        return $Collection;
    }


}