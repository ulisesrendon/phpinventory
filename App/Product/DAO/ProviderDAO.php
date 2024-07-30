<?php
namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

class ProviderDAO
{

    public DataBaseAccess $DBA;
    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DBA = $DataBaseAccess;
    }

    /**
     * Save new product data
     * @param string $code
     * @param string $title
     * @param string $description
     * @param float $price
     * @return bool|int|null
     */
    public function create(
        string $title,
        string $description = '',
    ): bool|string|null
    {
        return $this->DBA->singleInsertCommand("INSERT INTO providers(
                title,
                description
            ) VALUES(
                :title,
                :description
            )", [
                'title' => $title,
                'description' => $description,
            ]);
    }

    public function deleteByID(int $id): bool
    {
        return $this->DBA->executeCommand("DELETE FROM providers WHERE id = :id", [$id]);
    }

    public function getByID(int $id): ?object
    {
        return $this->DBA->fetchFirst("SELECT 
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
        return $this->DBA->fetchScalar("SELECT exists(
            SELECT title from providers where title ilike :title
        )", [$title]);
    }

    public function list(): ?array
    {
        return $this->DBA->fetchQuery("SELECT 
                id, 
                title,
                description,
                updated_at
            from providers
            where deleted_at is null
            order by title
        ");
    }

    public function update(int $id, array $fields): ?bool
    {
        if(empty($fields)){
            return null;
        }

        $FieldsCompacted = [];
        foreach($fields as $field => $value){
            $FieldsCompacted[] = "$field = :$field";
        }
        $FieldsString = implode(', ', $FieldsCompacted);

        return $this->DBA->executeCommand("UPDATE providers SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }
}