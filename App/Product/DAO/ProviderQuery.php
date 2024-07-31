<?php
namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

class ProviderQuery
{

    public DataBaseAccess $DataBaseAccess;
    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getByID(int $id): ?object
    {
        return $this->DataBaseAccess->fetchFirst("SELECT 
                id, 
                title,
                description,
                updated_at
            from providers
            where deleted_at is null and id = :id
        ", [$id]);
    }

    public function titleExists(string $title): ?bool
    {
        return $this->DataBaseAccess->fetchScalar("SELECT exists(
            SELECT title from providers where title ilike :title
        )", [$title]);
    }

    public function list(): ?array
    {
        return $this->DataBaseAccess->fetchQuery("SELECT 
                id, 
                title,
                description,
                updated_at
            from providers
            where deleted_at is null
            order by title
        ");
    }
}