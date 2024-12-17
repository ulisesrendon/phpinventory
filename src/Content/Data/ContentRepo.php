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

    public function getContentNodes(string $content): ?array
    {
        $items = $this->DataBaseAccess->query($this->getContentQuery('where content = :id'), ['id' => $content]);

        foreach ($items as $item) {
            $item->properties = json_decode($item->properties, true);
        }

        return $items;
    }

    public function getContent(string $id): ?object
    {
        $Content = $this->DataBaseAccess->select('SELECT id, path, title, properties, active, type from contents where id = :id ', ['id' => $id]);

        if (is_null($Content)) {
            return null;
        }

        $Content->properties = json_decode($Content->properties);

        $Content->nodes = $this->getContentNodes($Content->id);

        return $Content;
    }

    public function getContentExists(string $id): bool
    {
        $ContentExists = $this->DataBaseAccess->scalar('SELECT exists(SELECT id from contents where id = :id)', ['id' => $id]);

        return (bool) $ContentExists;
    }

    public function getCollectionExists(string $id): bool
    {
        $ContentExists = $this->DataBaseAccess->scalar('SELECT exists(SELECT id from collections where id = :id)', ['id' => $id]);

        return (bool) $ContentExists;
    }

    public function addContentToCollection(string $collection, string $content): bool
    {
        return $this->DataBaseAccess->command('INSERT IGNORE INTO collections_contents(collection_id, content_id) values 
                (:collection_id, :content_id) 
            ', [
            'collection_id' => $collection,
            'content_id' => $content,
        ]);
    }

    public function removeContentFromCollection(string $collection, string $content): bool
    {
        return $this->DataBaseAccess->command('DELETE FROM collections_contents WHERE collection_id = :collection_id AND content_id = :content_id', [
            'collection_id' => $collection,
            'content_id' => $content,
        ]);
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

    public function getCollection(string $id): ?object
    {
        $Collection = $this->DataBaseAccess->select('SELECT 
                id,
                title,
                properties,
                type
                from collections
                where 
                    id = :id
                limit 1
            ',
            [
                'id' => $id,
            ]
        );

        if (empty($Collection)) {
            return null;
        }

        $Collection->properties = json_decode($Collection->properties);

        return $Collection;
    }

    public function getCollectionContents(
        string $collectionId,
        string $siteUrl,
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $orderDirection = null,
    ): array {
        $orderBy ??= 'collections_contents.weight';
        $orderDirection ??= 'asc';

        $pagination = '';

        if (! is_null($limit) && ! is_null($offset)) {
            $pagination = "limit $limit offset $offset";
        } elseif (! is_null($limit) && is_null($offset)) {
            $pagination = "limit $limit";
        }

        $Contents = $this->DataBaseAccess->query("SELECT 
                contents.id,
                contents.path,
                contents.type,
                contents.title,
                contents.properties
                from contents
                join collections_contents on collections_contents.content_id = contents.id
                where 
                    collections_contents.collection_id = :collection_id
                    and contents.active is true
                order by
                    $orderBy $orderDirection
                $pagination
            ",
            [
                'collection_id' => $collectionId,
            ]
        );

        foreach ($Contents as $Content) {
            $Content->properties = json_decode($Content->properties);
            $Content->path = trim($Content->path, '/');
            $isPathAbsolute = (new Validator($Content->path))->url()->isCorrect();
            $Content->url = $isPathAbsolute ? $Content->path : implode('/', [$siteUrl, $Content->path]);
        }

        return $Contents;
    }
}
