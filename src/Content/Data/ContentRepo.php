<?php

namespace Stradow\Content\Data;

use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\Validator;

class ContentRepo
{
    protected DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getDatabaseAccess(): DataBaseAccess
    {
        return $this->DataBaseAccess;
    }

    public function getContentQuery(string $extraParts = ''): string
    {
        return "SELECT 
                id,
                parent,
                value,
                properties,
                weight,
                type
            from contentnodes
            $extraParts
            order by parent, weight
        ";
    }

    public function getContentNodes(string $content): array|null
    {
        $items = $this->DataBaseAccess->query($this->getContentQuery('where content = :id'), ['id' => $content]);

        foreach ($items as $item) {
            $item->properties = json_decode($item->properties, true);
        }

        return $items;
    }

    public function getContentById(string $id): ?object
    {
        $Content = $this->DataBaseAccess->select('SELECT id, path, title, properties, active, type from contents where id = :id ', ['id' => $id]);

        if (is_null($Content)) {
            return null;
        }

        $Content->properties = json_decode($Content->properties);

        $Content->nodes = $this->getContentNodes($Content->id);

        return $Content;
    }

    public function getContentByPath(string $path): ?object
    {
        $Content = $this->DataBaseAccess->select('SELECT id, path, title, properties, active, type from contents where path = :path ', ['path' => $path]);

        if (is_null($Content)) {
            return null;
        }

        $Content->properties = json_decode($Content->properties);
        
        $Content->nodes = $this->getContentNodes($Content->id);

        return $Content;
    }

    public function getCollectionByTitle(string $title): ?object
    {
        $Collection = $this->DataBaseAccess->select('SELECT 
                collections.id,
                collections.title,
                collections.properties,
                collections.type
                from collections
                where 
                    collections.title = :collection_title
                limit 1
            ',
            [
                'collection_title' => $title,
            ]
        );

        if (empty($Collection)) {
            return null;
        }

        $Collection->properties = json_decode($Collection->properties);

        $Contents = $this->DataBaseAccess->query('SELECT 
                contents.id,
                contents.path,
                contents.type,
                contents.title,
                contents.properties
                from contents
                join collections_contents on collections_contents.content_id = contents.id
                where 
                    collections_contents.collection_id = :collection_id
                order by
                    collections_contents.weight
            ',
            [
                'collection_id' => $Collection->id,
            ]
        );

        foreach ($Contents as $Content) {
            $Content->properties = json_decode($Content->properties);
            $Content->url = (new Validator($Content->path))->url()->isCorrect() ? $Content->path : "http://phpinventory.test/{$Content->path}";
        }

        $Collection->Contents = $Contents;

        return $Collection;
    }
}
