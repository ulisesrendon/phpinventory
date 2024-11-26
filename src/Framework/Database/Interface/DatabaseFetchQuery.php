<?php

namespace Stradow\Framework\Database\Interface;

interface DatabaseFetchQuery
{
    public function query(string $query, array $params = []): ?array;
}
