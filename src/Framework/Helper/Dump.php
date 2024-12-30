<?php
namespace Stradow\Framework\Helper;

class Dump
{
    public static function json(mixed $content)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($content);
        exit();
    }
}