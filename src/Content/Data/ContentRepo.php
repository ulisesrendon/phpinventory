<?php

namespace Stradow\Content\Data;

use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\Database\UpsertHelper;
use Stradow\Framework\Render\Interface\RepoInterface;
use Stradow\Framework\Validator;

class ContentRepo implements RepoInterface
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

    public function getContentsQuery(string $extraParts = ''): string
    {
        return "SELECT 
                contents.id,
                contents.path,
                contents.title,
                contents.active,
                contents.type,
                contents.parent,
                contents.weight
            from contents
            $extraParts
            order by parent, weight
        ";
    }

    public function getContentNodesQuery(string $extraParts = ''): string
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

    public function getContentNodes(int|float|string $content): array
    {
        $items = $this->DataBaseAccess->query($this->getContentNodesQuery('where content = :id'), ['id' => $content]);

        if (empty($items)) {
            return [];
        }

        foreach ($items as $item) {
            $item->properties = json_decode($item->properties, true);
        }

        return $items;
    }

    public function getContentList(): ?array
    {
        $items = $this->DataBaseAccess->query($this->getContentsQuery());

        foreach ($items as $item) {
            $item->properties = json_decode($item->properties, true);
        }

        return $items;
    }

    public function getContent(int|float|string $id): ?object
    {
        $Content = $this->DataBaseAccess->select('SELECT id, path, title, properties, active, type from contents where id = :id ', ['id' => $id]);

        if (is_null($Content)) {
            return null;
        }

        $Content->properties = json_decode($Content->properties);

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

        return $Content;
    }

    public function getCollectionList(string $extra = ''): array
    {
        $Collections = $this->DataBaseAccess->query("SELECT 
            collections.id,
            collections.title,
            collections.type,
            collections.parent,
            collections.weight
            from collections
            $extra
        ");

        if (empty($Collections)) {
            return [];
        }

        foreach ($Collections as $Collection) {
            $Collection->properties = json_decode($Collection->properties);
        }

        return $Collections;
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
        $pagination = '';
        if (! is_null($limit) && ! is_null($offset)) {
            $pagination = "limit $limit offset $offset";
        } elseif (! is_null($limit) && is_null($offset)) {
            $pagination = "limit $limit";
        }

        $orderBy ??= 'collections_contents.weight';
        if ($orderBy === 'weight') {
            $orderBy = "collections_contents.$orderBy";
        } elseif ($orderBy === 'url') {
            $orderBy = 'contents.path';
        }

        $orderDirection ??= 'asc';

        $Contents = $this->DataBaseAccess->query("SELECT 
                contents.id,
                contents.path,
                contents.type,
                contents.title,
                contents.properties,
                collections_contents.weight
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

    public function deleteNodes(array $list): bool
    {
        $params = [];
        foreach ($list as $k => $id) {
            $params["id_$k"] = $id;
        }
        $markers = implode(', :', array_keys($params));

        return $this->DataBaseAccess->command(
            query: "DELETE FROM contentnodes WHERE id in(:$markers)",
            params: $params
        );
    }

    public function saveCollection(array $fields): bool
    {
        $UpsertHelper = new UpsertHelper($fields, ['id']);

        return $this->DataBaseAccess->command(
            query: "INSERT INTO collections({$UpsertHelper->columnNames}) values 
                ({$UpsertHelper->allPlaceholders}) 
                ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
            ",
            params: $UpsertHelper->parameters,
        );
    }

    public function saveContent(array $fields): bool
    {
        $UpsertHelper = new UpsertHelper($fields, ['id']);

        return $this->DataBaseAccess->command(
            query: "INSERT INTO contents({$UpsertHelper->columnNames}) 
                        values ({$UpsertHelper->allPlaceholders}) 
                        ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
                    ",
            params: $UpsertHelper->parameters,
        );
    }

    public function saveContentNodes(array $nodes): bool
    {
        $result = true;
        foreach ($nodes as $node) {
            $UpsertHelper = new UpsertHelper($node, ['id']);
            $result &= $this->DataBaseAccess->command(
                query: "INSERT INTO contentnodes({$UpsertHelper->columnNames}) 
                        values ({$UpsertHelper->allPlaceholders}) 
                        ON DUPLICATE KEY UPDATE {$UpsertHelper->noUniquePlaceHolders}
                    ",
                params: $UpsertHelper->parameters,
            );
        }

        return (bool) $result;
    }

    public function getContentBranchRelatedNodes(string $id, string $direction = 'asc'): array
    {
        $directions = [
            'asc' => 'b.id = a.parent',
            'desc' => 'b.parent = a.id',
        ];

        $selectedDIrection = $directions[strtolower($direction)] ?? $directions['asc'];

        return $this->DataBaseAccess->query(
            query: "WITH RECURSIVE related 
                AS (
                    SELECT id, parent, path, title, properties, type, weight
                    FROM contents
                    WHERE id = :id and active is true
                    UNION ALL
                    SELECT b.id, b.parent, b.path, b.title, b.properties, b.type, b.weight
                    FROM contents b
                    INNER JOIN related a ON $selectedDIrection
                )
                SELECT * FROM related order by weight;
            ",
            params: ['id' => $id],
        );
    }
}
