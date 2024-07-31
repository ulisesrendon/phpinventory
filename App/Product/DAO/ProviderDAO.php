<?php
namespace App\Product\DAO;

use Lib\Database\DataBaseAccess;

class ProviderDAO
{

    public DataBaseAccess $DataBaseAccess;
    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
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
        return $this->DataBaseAccess->singleInsertCommand("INSERT INTO providers(
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
        return $this->DataBaseAccess->executeCommand("DELETE FROM providers WHERE id = :id", [$id]);
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

        return $this->DataBaseAccess->executeCommand("UPDATE providers SET $FieldsString WHERE id = :id", [
            'id' => $id,
            ...$fields,
        ]);
    }
}