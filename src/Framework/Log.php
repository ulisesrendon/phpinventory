<?php
namespace App\Framework;

class Log
{
    public static function append( string $content, ?string $path = null ): ?bool{
        if( is_null($path) ){
            $path = __DIR__.'/../../logs/log.txt';
        }

        if( empty($path) ){
            return null;
        }

        if( is_dir($path) ){
            return null;
        }

        return file_put_contents($path, $content . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}