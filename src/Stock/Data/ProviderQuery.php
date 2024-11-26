<?php

namespace Stradow\Stock\Data;

use Stradow\Framework\Database\DataBaseAccess;

class ProviderQuery
{
    public DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getByID(int $id): ?object
    {
        return $this->DataBaseAccess->select('SELECT 
                id, 
                title,
                description,
                updated_at
            from providers
            where deleted_at is null and id = :id
        ', ['id' => $id]);
    }

    public function titleExists(string $title): ?bool
    {
        return $this->DataBaseAccess->scalar('SELECT exists(
            SELECT title from providers where title like :title
        )', ['title' => $title]);
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->query('SELECT 
                id, 
                title,
                description,
                updated_at
            from providers
            where deleted_at is null
            order by title
        ');
    }
}
