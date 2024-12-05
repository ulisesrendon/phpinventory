<?php

namespace Stradow\Blog\Data;

use Stradow\Framework\Database\DataBaseAccess;

class BlogQuery
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

    public function getContentById(int $id): ?array
    {
        $items = $this->DataBaseAccess->query($this->getContentQuery('where content = :id'), ['id' => $id]);

        foreach($items as $item){
            $item->properties = json_decode($item->properties);
            $item->children = [];
        }
        return $items;
    }


}