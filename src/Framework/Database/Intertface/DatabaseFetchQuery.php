<?php

namespace App\Framework\Database\Intertface;

interface DatabaseFetchQuery
{
    public function query(string $query, array $params = []): ?array;
}
