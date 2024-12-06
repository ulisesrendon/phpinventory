<?php
namespace Stradow\Blog\Render\Interface;

use Stradow\Blog\Render\Interface\RendereableInterface;


interface RendereableNodeInterface
{
    public function getRender(): RendereableInterface;
}