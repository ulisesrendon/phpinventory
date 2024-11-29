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
                contents.id,
                contents.title,
                contents.description,
                contents.path,
                contents.name
            from contents
            where deleted_at is null $extraParts";
    }

    public function getById(int $id): ?object
    {
        $contentQuery = "SELECT 
                contents.id,
                contents.content_type_id,
                contents.name,
                contents.path,
                contents.title,
                contents.description,
                contents.body,
                contents.config,
                contents.status,
                contents.created_at,
                contents.updated_at
            from contents
            where 
                deleted_at is null
                and contents.id = :id
            ";

        return $this->DataBaseAccess->query($contentQuery, ['id' => $id])[0] ?? null;
    }

    public function list(?array $ids = null): ?array
    {
        $idCondition = '';
        $params = [];
        if (! empty($ids)) {
            foreach ($ids as $id) {
                $params["id_$id"] = $id;
            }
            $markers = implode(',:', array_keys($params));
            $idCondition = "and contents.id in (:$markers) ";
        }

        return $this->DataBaseAccess->query($this->getContentQuery($idCondition.'order by contents.id'));
    }

    public function fieldList(): array
    {
        $query = "SELECT 
                fields.id,
                fields.name,
                fields.title,
                fields.description,
                fields.config,
                field_types.name as type
            from fields
            left join field_types on field_types.id = fields.type
            where 
                fields.deleted_at is null
            order by
                fields.title asc
            ";

        return $this->DataBaseAccess->query($query );
    }
    
    public function typeList(): array
    {
        $query = "SELECT id, title, name, description, config
            from content_types
            where 
                deleted_at is null
            order by
                title asc
            ";

        return $this->DataBaseAccess->query($query );
    }
}
