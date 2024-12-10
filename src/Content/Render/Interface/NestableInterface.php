<?php
namespace Stradow\Content\Render\Interface;

interface NestableInterface
{
    public function getParent();

    public function addChild(object $child);
}