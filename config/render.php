<?php

use Stradow\Blog\Render\Block\ImgBlock;
use Stradow\Blog\Render\Block\ItemBlock;
use Stradow\Blog\Render\Block\ListBlock;
use Stradow\Blog\Render\Block\TextBlock;
use Stradow\Blog\Render\Block\TableBlock;
use Stradow\Blog\Render\Block\DefaultBlock;
use Stradow\Blog\Render\Block\HeadingBlock;
use Stradow\Blog\Render\Block\ContainerBlock;
use Stradow\Blog\Render\Block\PlainCodeBlock;

return [
    'default' => DefaultBlock::class,
    'container' => ContainerBlock::class,
    'text' => TextBlock::class,
    'img' => ImgBlock::class,
    'h1' => HeadingBlock::class,
    'h2' => HeadingBlock::class,
    'h3' => HeadingBlock::class,
    'h4' => HeadingBlock::class,
    'h5' => HeadingBlock::class,
    'h6' => HeadingBlock::class,
    'item' => ItemBlock::class,
    'ul' => ListBlock::class,
    'ol' => ListBlock::class,
    'code-plain' => PlainCodeBlock::class,
    'table' => TableBlock::class,
    'row' => TableBlock::class,
    'table-heading' => TableBlock::class,
    'cell' => TableBlock::class,
];
