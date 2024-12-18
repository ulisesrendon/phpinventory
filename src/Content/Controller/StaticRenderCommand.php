<?php

namespace Stradow\Content\Controller;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Content\Data\ContentRepo;
use Stradow\Framework\Config;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Render\HyperItemsRender;
use Stradow\Framework\Render\HyperNode;

require __DIR__.'/../../../bootstrap/app.php';

class StaticRenderCommand
{
    public static function forceFilePutContents(string $filePath, mixed $data, int $flags = 0)
    {
        $dirPathOnly = dirname($filePath);
        if (! is_dir($dirPathOnly)) {
            mkdir($dirPathOnly, 0775, true);
        }
        file_put_contents($filePath, $data, $flags);
    }

    public static function start()
    {
        $DataBaseAccess = Container::get(DataBaseAccess::class);
        $ContentRepo = new ContentRepo($DataBaseAccess);

        $Contents = $DataBaseAccess->query("SELECT 
            contents.path
            from contents 
            where 
            contents.active is true
            and type != 'link'
        ");

        $SiteConfig = Container::get(Config::class);
        $staticPath = $SiteConfig->get('staticpath') ?? 'public/static';
        $staticDir = realpath(BASE_DIR."/$staticPath");

        $created = [];
        foreach ($Contents as $Page) {

            $Content = $ContentRepo->getContentByPath($Page->path);

            $ContentNodes = $ContentRepo->getContentNodes($Content->id);
            $HyperRender = new HyperItemsRender;
            foreach ($ContentNodes as $item) {
                $HyperRender->addNode(
                    id: $item->id,
                    node: new HyperNode(
                        id: $item->id,
                        value: $item->value,
                        properties: $item->properties,
                        type: $item->type ?? 'default',
                        parent: $item->parent,
                        RenderEngine: new (RENDER_CONFIG[$item->type] ?? RENDER_CONFIG['default']),
                        context: [
                            'Content' => $Content,
                            'Tree' => $HyperRender,
                            'Repo' => $ContentRepo,
                            'Config' => $SiteConfig,
                        ],
                    )
                );
            }

            $template = $Content?->properties?->template ?? 'templates/page.template.php';

            $Render = new TemplateRender(
                filepath: CONTENT_DIR."/$template",
                context: [
                    'Content' => $Content,
                    'Config' => $SiteConfig,
                    'render' => $HyperRender->render($Content->properties->prettify ?? true),
                ]
            );

            $extension = pathinfo($Page->path)['extension'] ?? '';

            if (empty($extension)) {
                $Page->path .= '.html';
            }

            self::forceFilePutContents($staticDir."/{$Page->path}", (string) $Render);

            $created[] = $staticDir."/{$Page->path}";
        }

        $dateTimeString = date('YmdHi');
        $logFilePath = BASE_DIR."/logs/render_list_$dateTimeString.json";
        self::forceFilePutContents($logFilePath, json_encode($created, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        file_put_contents('php://output', 'Static Render Complete: '.realpath($logFilePath).PHP_EOL);
    }
}
