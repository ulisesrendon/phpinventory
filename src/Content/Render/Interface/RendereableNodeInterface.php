<?php
namespace Stradow\Content\Render\Interface;

use Stradow\Content\Render\Interface\RendereableInterface;


interface RendereableNodeInterface
{
    public function getRender(): RendereableInterface;
}