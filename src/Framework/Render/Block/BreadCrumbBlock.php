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

        $AncestorNodes = $Content->getRepo()->getContentBranchRelatedNodes($Content->getId());

        $BreadCrumb = [
            (object) [
                'url' => $Content->getConfig('site_url'),
                'anchor' => $State->getValue() ?? 'Index',
                'isLast' => false,
            ],
        ];

        $nodeMap = [];
        foreach ($AncestorNodes as $k => $Node) {
            $nodeMap[$Node->id] = $Node;
        }

        $NodeList = [];
        foreach ($nodeMap as $k => $Node) {
            $nodeMap[$k]->next ??= null;
            if (isset($nodeMap[$Node->parent])) {
                $nodeMap[$Node->parent]->next = $Node;
            } else {
                $NodeList = $Node;
            }
        }

        $actualNode = $NodeList;
        while (true) {
            $Item = (object) [
                'url' => "{$Content->getConfig('site_url')}/{$actualNode->path}",
                'anchor' => $actualNode->title,
                'isLast' => false,
            ];

            $BreadCrumb[] = $Item;

            if (is_null($actualNode->next)) {
                $Item->isLast = true;
                break;
            }

            $actualNode = $actualNode->next;
        }

        $template = $State->getProperty('template') ?? 'templates/breadcrumb.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'BreadCrumb' => $BreadCrumb,
        ]);
    }
}
