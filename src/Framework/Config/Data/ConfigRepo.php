<?php

namespace Stradow\Framework\Config\Data;

use Stradow\Framework\Database\DataBaseAccess;

class ConfigRepo
{
    protected DataBaseAccess $DataBaseAccess;

    public function __construct(DataBaseAccess $DataBaseAccess)
    {
        $this->DataBaseAccess = $DataBaseAccess;
    }

    public function getConfigAll(): ?array
    {
        try{
            return $this->DataBaseAccess->query('SELECT name, value from config where autoload is true');
        }catch(\Exception $e){
            
        }
        return [];
    }
}
