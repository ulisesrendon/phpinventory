<?php
namespace Lib\Http;

class ApiResponse
{
    public function __construct()
    {
    }

    public static function json(
        mixed $data = null,
        int $status = null,
    )
    {
        header('Content-Type: application/json');
        http_response_code($status ?? 200);
        ob_clean();
        echo json_encode($data);
        exit();
    }
    
    public static function xml(
        string $data = '',
        int $status = null,
    ) {
        header('Content-Type: text/xml; charset=utf-8');
        http_response_code($status ?? 200);
        ob_clean();
        echo $data;
        exit();
    }

    public static function html(
        string $data = '',
        int $status = null,
    ) 
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code($status ?? 200);
        ob_clean();
        echo $data;
        exit();
    }

    public static function csv(
        string $data = '',
        int $status = null,
    ) 
    {
        header('Content-Type: text/csv; charset=utf-8');
        http_response_code($status ?? 200);
        ob_clean();
        echo $data;
        exit();
    }
}