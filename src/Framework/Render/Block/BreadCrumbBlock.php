<?php

namespace Stradow\Framework\Render\Block;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Interface\NodeContextInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

class BreadCrumbBlock implements RendereableInterface
{
    public function render(NodeContextInterface $Context): string
    {
        /**
         * @var \Stradow\Content\Data\ContentRepo $ContentRepo
         */
        $ContentRepo = $Context->getExtra('Repo');

        /**
         * @var \Stradow\Framework\Config $Config
         */
        $Config = $Context->getExtra('Config');

        $AncestorNodes = $ContentRepo->getContentBranchRelatedNodes($Context->getExtra('Content')->id);

        $BreadCrumb = [
            (object) [
                'url' => $Config->get('site_url'),
                'anchor' => $Context->getValue() ?? 'Index',
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
                'url' => "{$Config->get('site_url')}/{$actualNode->path}",
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

        $template = $Context->getProperties('template') ?? 'templates/breadcrumb.template.php';

        return (string) new TemplateRender(CONTENT_DIR."/$template", [
            'BreadCrumb' => $BreadCrumb,
        ]);
    }
}
