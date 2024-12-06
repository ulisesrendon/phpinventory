<?php

use Stradow\Blog\Render\HyperItemsRenderForH1;
use Stradow\Blog\Render\HyperItemsRenderForUl;
use Stradow\Blog\Render\HyperItemsRenderForImg;
use Stradow\Blog\Render\HyperItemsRenderDefault;
use Stradow\Blog\Render\HyperItemsRenderForItem;
use Stradow\Blog\Render\HyperItemsRenderForText;
use Stradow\Blog\Render\HyperItemsRenderForContainer;
use Stradow\Blog\Render\HyperItemsRenderForPlainCode;

return [
    'default' => HyperItemsRenderDefault::class,
    'container' => HyperItemsRenderForContainer::class,
    'text' => HyperItemsRenderForText::class,
    'img' => HyperItemsRenderForImg::class,
    'h1' => HyperItemsRenderForH1::class,
    'item' => HyperItemsRenderForItem::class,
    'ul' => HyperItemsRenderForUl::class,
    'code-plain' => HyperItemsRenderForPlainCode::class,
];
