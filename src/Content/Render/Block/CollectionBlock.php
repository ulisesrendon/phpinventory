<?php
namespace Stradow\Content\Render\Block;

use Stradow\Framework\Validator;
use Stradow\Framework\Database\DataBaseAccess;
use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Content\Render\Interface\NodeContextInterface;
use Stradow\Content\Render\Interface\RendereableInterface;

class CollectionBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        /**
         * @var \Stradow\Content\Data\ContentRepo $ContentRepo
         */
        $ContentRepo = $Context->getExtra('repo');

        $Collection = $ContentRepo->getCollectionByTitle($Context->getValue());

        return (string) new TemplateRender(CONTENT_DIR."/{$Collection->properties->template}", [
            'Collection' => $Collection,
        ]);
    }
}