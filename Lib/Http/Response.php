<?php

namespace Lib\Http;

class Response
{
    public int $status;
    public string $content;
    public array $headers;

    public function __construct(
        string $content = '',
        int $status = 200,
        array $headers = [],
    ) {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function render(): string
    {
        http_response_code($this->status);
        foreach($this->headers as $header){
            header($header);
        }
        return (string) new TextRender($this->content);
    }

    public static function json(
        mixed $content = null,
        int $status = 200,
    ) {
        return new self(
            json_encode($content), $status, ['Content-Type: application/json']
        );
    }

    public static function xml(
        string $content = '',
        int $status = 200,
    ) {
        return new self($content, $status, ['Content-Type: text/xml; charset=utf-8']);
    }

    public static function html(
        string $content = '',
        int $status = 200,
    ) {
        return new self($content, $status, ['Content-Type: text/html; charset=utf-8']);
    }

    public static function csv(
        string $content = '',
        int $status = 200,
    ) {
        return new self($content, $status, ['Content-Type: text/csv; charset=utf-8']);
    }

    public static function template(
        string $content = '',
        int $status = 200,
    ) {
        $content = (string) new TextRenderFromFile($content);
        return new self($content, $status);
    }
}
