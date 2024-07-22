<?php
namespace App\Lib\Http;

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
}