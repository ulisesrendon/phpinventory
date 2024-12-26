<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\ContentStateInterface;
use Stradow\Framework\Render\Interface\NodeStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class BreadCrumbBlock implements RendereableInterface
{
    public function render(
        NodeStateInterface $State,
        ContentStateInterface $Content,
    ): string {
        $BreadCrumb = [
            $this->BreadCrumbItemFactory(
                url: $Content->getConfig('site_url'),
                anchor: $State->getValue() ?? 'Index',
            ),
        ];

        $this->linkedListGenerator(
            list: $Content->getRepo()->getContentBranchRelatedNodes($Content->getId(), 'asc'),
            callback: function (object $actualNode) use ($Content, &$BreadCrumb) {
                $Item = $this->BreadCrumbItemFactory(
                    url: "{$Content->getConfig('site_url')}/{$actualNode->path}",
                    anchor: $actualNode->title,
                );

                if (is_null($actualNode->next)) {
                    $Item->isLast = true;
                }

                $BreadCrumb[] = $Item;
            }
        );

        $template = $State->getProperty('template') ?? 'templates/breadcrumb.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'Content' => $Content,
            'Block' => $State,
            'BreadCrumb' => $BreadCrumb,
        ]);
    }

    public function BreadCrumbItemFactory(
        string $url,
        string $anchor,
        bool $isLast = false,
    ): object {
        return new class($url, $anchor, $isLast)
        {
            public function __construct(
                public string $url,
                public string $anchor,
                public bool $isLast,
            ) {}
        };
    }

    /**
     * @param  object[]  $Nodes
     */
    public function createLinkedList(array $Nodes): ?object
    {
        $nodeMap = [];
        foreach ($Nodes as $k => $Node) {
            $nodeMap[$Node->id] = $Node;
        }

        $LinkedList = null;
        foreach ($nodeMap as $k => $Node) {
            $nodeMap[$k]->next ??= null;
            if (isset($nodeMap[$Node->parent ?? null])) {
                $nodeMap[$Node->parent]->next = $Node;
            } else {
                $LinkedList = $Node;
            }
        }

        return $LinkedList;
    }

    /**
     * @param  object[]  $list
     * @param  callable(object)  $callback
     */
    public function linkedListGenerator(array $list, \Closure $callback): void
    {
        $actualNode = $this->createLinkedList($list);
        while ($actualNode) {
            $callback($actualNode);
            $actualNode = $actualNode->next;
        }
    }
}
