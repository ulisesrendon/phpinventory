<?php
namespace Stradow\Blog\Render\Interface;

interface NestableInterface
{
    public function getParent();

    public function addChild(object $child);
}