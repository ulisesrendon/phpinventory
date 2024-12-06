<?php
namespace Stradow\Blog\Render\Interface;

interface RendereableInterface
{
    public function render(NodeContextInterface $context): string;
}