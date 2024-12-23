<?php

namespace Stradow\Content\Controller;

use Stradow\Framework\Config;
use Stradow\Content\Data\ContentRepo;
use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\Render\HyperItemsRender;
use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Framework\Render\Data\ContentState;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Render\HyperRenderApplication;

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
            contents.id
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

            $HyperRenderApp = new HyperRenderApplication(
                id: $Page->id,
                Repo: $ContentRepo,
                config: $SiteConfig->get(),
                renderConfig: RENDER_CONFIG,
                renderLayout: true,
            );
            $HyperRender = $HyperRenderApp->getHyperRender();
            $Content = $HyperRenderApp->getContent();

            $template = $Content?->properties?->template ?? 'templates/page.template.php';

            $Render = new TemplateRender(
                filepath: CONTENT_DIR."/$template",
                context: [
                    'Content' => $Content,
                    'Config' => $SiteConfig,
                    'render' => $HyperRender->render($Content->properties->prettify ?? true),
                ]
            );

            $extension = pathinfo($Content->path)['extension'] ?? '';

            if (empty($extension)) {
                $Content->path .= '.html';
            }

            self::forceFilePutContents($staticDir."/{$Content->path}", (string) $Render);

            $created[] = $staticDir."/{$Content->path}";
        }

        $dateTimeString = date('YmdHi');
        $logFilePath = BASE_DIR."/logs/render_list_$dateTimeString.json";
        self::forceFilePutContents($logFilePath, json_encode($created, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        file_put_contents('php://output', 'Static Render Complete: '.realpath($logFilePath).PHP_EOL);
    }
}
