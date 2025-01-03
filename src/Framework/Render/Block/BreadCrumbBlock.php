<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class BreadCrumbBlock implements RendereableInterface
{
    protected static array $List = [];

    public function render(
        BlockStateInterface $State,
        GlobalStateInterface $GlobalState,
    ): string {
        $BreadCrumb = [
            $this->BreadCrumbItemFactory(
                url: $GlobalState->getConfig('site_url'),
                anchor: $State->getValue() ?? 'Index',
            ),
        ];

        $id = $GlobalState->getId();
        self::$List[$id] ??= $GlobalState->getRepo()->getContentBranchRelatedNodes($id, 'asc');

        $this->linkedListGenerator(
            list: self::$List[$id],
            callback: function (object $actualNode) use ($GlobalState, &$BreadCrumb) {
                $Item = $this->BreadCrumbItemFactory(
                    url: "{$GlobalState->getConfig('site_url')}/{$actualNode->path}",
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
            'Block' => $State,
            'Content' => $GlobalState,
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
