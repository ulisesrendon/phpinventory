<?php

namespace Stradow\Framework\Render\Interface;

interface RepoInterface
{
    /**
     * @param  scalar  $id
     */
    public function getContent(int|float|string $id): ?object;

    /**
     * @param  scalar  $id
     */
    public function getContentNodes(int|float|string $id): array;
}
