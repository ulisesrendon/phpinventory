<?php

namespace Lib\Database;

interface DatabaseFetchQuery
{
    public function fetchQuery(string $query, array $params = []): ?array;
}
