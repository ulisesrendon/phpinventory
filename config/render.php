<?php

use Stradow\Framework\Render\Block\ImgBlock;
use Stradow\Framework\Render\Block\HtmlBlock;
use Stradow\Framework\Render\Block\ItemBlock;
use Stradow\Framework\Render\Block\ListBlock;
use Stradow\Framework\Render\Block\TextBlock;
use Stradow\Framework\Render\Block\TableBlock;
use Stradow\Framework\Render\Block\ContentBlock;
use Stradow\Framework\Render\Block\DefaultBlock;
use Stradow\Framework\Render\Block\HeadingBlock;
use Stradow\Framework\Render\Block\ContainerBlock;
use Stradow\Framework\Render\Block\PlainCodeBlock;
use Stradow\Framework\Render\Block\BreadCrumbBlock;
use Stradow\Framework\Render\Block\CollectionBlock;
use Stradow\Framework\Render\Block\ArticlePrevNextBlock;

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
    'content' => ContentBlock::class,
    'html' => HtmlBlock::class,
    'prev-next-links' => ArticlePrevNextBlock::class,
    'breadcrumb' => BreadCrumbBlock::class,
];
