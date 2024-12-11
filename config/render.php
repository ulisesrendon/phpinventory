<?php

use Stradow\Content\Render\Block\ImgBlock;
use Stradow\Content\Render\Block\ItemBlock;
use Stradow\Content\Render\Block\ListBlock;
use Stradow\Content\Render\Block\TextBlock;
use Stradow\Content\Render\Block\TableBlock;
use Stradow\Content\Render\Block\DefaultBlock;
use Stradow\Content\Render\Block\HeadingBlock;
use Stradow\Content\Render\Block\ContainerBlock;
use Stradow\Content\Render\Block\PlainCodeBlock;
use Stradow\Content\Render\Block\CollectionBlock;

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
    'collection' => CollectionBlock::class,
];
