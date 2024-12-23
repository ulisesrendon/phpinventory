<?php
namespace Stradow\Framework\Render\Interface;

interface RepoInterface
{
    /**
     * @param scalar $id
     * @return object|null
     */
    public function getContent(int|float|string $id): ?object;

    /**
     * @param scalar $id
     * @return array
     */
    public function getContentNodes(int|float|string $id): array;
}