<?php
namespace Stradow\Framework\Database\Event;

class QueryExecuted
{
    public function __construct(
        private readonly string $query, 
        private readonly array $params
    )
    {
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}