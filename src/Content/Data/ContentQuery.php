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


}