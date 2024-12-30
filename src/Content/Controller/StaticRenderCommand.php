<?php

namespace Stradow\Content\Controller;

use Neuralpin\HTTPRouter\Helper\TemplateRender;
use Stradow\Content\Data\ContentRepo;
use Stradow\Framework\Config;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\DirectoryCleaner;
use Stradow\Framework\FileCopier;
use Stradow\Framework\Log;
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

        $assetsPath = $SiteConfig->get('assetspath');
        $shouldCopyAssets = ! empty($assetsPath);
        $assetsDir = realpath(BASE_DIR."/$assetsPath");

        try {
            $directoryCleaner = new DirectoryCleaner($staticDir);
            $directoryCleaner->deleteFiles();
            file_put_contents('php://output', 'Cleaning output static dir...'.PHP_EOL);
        } catch (\Exception $e) {
            log::append(json_encode($e, JSON_PRETTY_PRINT));
            file_put_contents('php://output', 'Error trying to clean dir'.PHP_EOL);
            exit();
        }

        if ($shouldCopyAssets) {
            try {
                $fileCopier = new FileCopier($assetsDir, $staticDir);
                $fileCopier->copyFiles();
                file_put_contents('php://output', 'Copying asset files...'.PHP_EOL);
            } catch (\Exception|\Throwable $e) {
                log::append(json_encode($e->getMessage(), JSON_PRETTY_PRINT));
                file_put_contents('php://output', 'Error while trying to copy files'.PHP_EOL);
                exit();
            }
        }

        $created = [];
        foreach ($Contents as $Page) {

            $HyperRenderApp = new HyperRenderApplication(
                id: $Page->id,
                Repo: $ContentRepo,
                config: $SiteConfig->get(),
                renderConfig: RENDER_CONFIG,
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
        file_put_contents('php://output', 'Generating content files...'.PHP_EOL);

        file_put_contents('php://output', 'Static Render Complete: '.realpath($logFilePath).PHP_EOL);
    }
}
