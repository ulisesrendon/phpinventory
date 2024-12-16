<?php

namespace Stradow\Framework\Render\Interface;

interface NestableInterface
{
    public function getParent();

    public function addChild(object $child);
}