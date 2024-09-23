<?php

namespace App\Shared\Database;

interface DatabaseFetchQuery
{
    public function fetchQuery(string $query, array $params = []): ?array;
}
