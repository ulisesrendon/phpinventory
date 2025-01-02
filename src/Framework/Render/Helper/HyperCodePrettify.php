<?php

namespace Stradow\Framework\Render\Helper;

use Stradow\Framework\Render\Interface\PrettifierInterface;

final class HyperCodePrettify implements PrettifierInterface
{
    public function prettify(string $html): string
    {
        $config = [
            'show-body-only' => true,
            'indent' => true,
            'drop-empty-elements' => 0,
            'new-blocklevel-tags' => 'article aside audio bdi canvas details dialog figcaption figure footer header hgroup main menu menuitem nav section source summary template track video',
            'new-empty-tags' => 'command embed keygen source track wbr',
            'new-inline-tags' => 'audio command datalist embed keygen mark menuitem meter output progress source time video wbr',
            'tidy-mark' => 0,
            'indent-spaces' => 4,
            'wrap' => 200,
        ];

        $replace = [
            '@' => 'at------',
        ];

        $html = str_replace(array_keys($replace), array_values($replace), $html);
        $html = tidy_parse_string($html, $config, 'utf8');
        $html = str_replace(array_values($replace), array_keys($replace), $html);

        return (string) $html;
    }

    public function minify(string $html): string
    {
        $config = [
            'show-body-only' => true,
            'indent' => false,
            'drop-empty-elements' => 0,
            'new-blocklevel-tags' => 'article aside audio bdi canvas details dialog figcaption figure footer header hgroup main menu menuitem nav section source summary template track video',
            'new-empty-tags' => 'command embed keygen source track wbr',
            'new-inline-tags' => 'audio command datalist embed keygen mark menuitem meter output progress source time video wbr',
            'tidy-mark' => 0,
            'indent-spaces' => 4,
            'strict-error-checking' => false,
            'wrap' => 0,
            'clean' => true,
            'output-html' => true,
            'hide-comments' => true,
        ];

        $replace = [
            '@' => 'at------',
        ];

        $html = str_replace(array_keys($replace), array_values($replace), $html);
        $html = tidy_parse_string($html, $config, 'utf8');
        // tidy_clean_repair($this->html);
        $html = str_replace(array_values($replace), array_keys($replace), $html);

        return (string) $html;
    }
}
