<?php

namespace Lib\Http;

use Lib\Http\ResponseRender;
use Lib\Http\Contracts\ResponseState;

class Response
{
    public static function json(
        mixed $content = null,
        int $status = 200,
        array $headers = [],
    ): ResponseState 
    {
        return new ResponseRender(
            json_encode($content), $status, [...$headers, 'Content-Type: application/json']
        );
    }

    public static function xml(
        string $content = '',
        int $status = 200,
        array $headers = [],
    ): ResponseState 
    {
        return new ResponseRender(
            $content, $status, [...$headers, 'Content-Type: text/xml; charset=utf-8'],
        );
    }    

    public static function csv(
        string $content = '',
        int $status = 200,
        array $headers = [],
    ): ResponseState
    {
        return new ResponseRender(
            $content, $status, [...$headers, 'Content-Type: text/csv; charset=utf-8'],
        );
    }

    public static function html(
        string $content = '',
        int $status = 200,
        array $headers = [],
    ): ResponseState 
    {
        return new ResponseRender(
            $content,
            $status,
            [...$headers, 'Content-Type: text/html; charset=utf-8'],
        );
    }

    public static function template(
        string $content = '',
        int $status = 200,
        array $headers = [],
    ): ResponseState 
    {
        $content = (string) new TextRenderFromFile($content);
        return new ResponseRender($content, $status, $headers);
    }
}
