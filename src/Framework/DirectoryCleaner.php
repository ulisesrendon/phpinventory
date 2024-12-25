<?php
namespace Stradow\Framework;

use Exception;

class DirectoryCleaner {
    private $directory;

    public function __construct($directory) {
        $this->directory = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR;
    }

    public function deleteFiles() {
        if (!is_dir($this->directory)) {
            throw new Exception("Directory does not exist: " . $this->directory);
        }

        $files = scandir($this->directory);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $this->directory . $file;
                if (is_file($filePath)) {
                    if (!unlink($filePath)) {
                        throw new Exception("Failed to delete file: " . $file);
                    }
                } else if (is_dir($filePath)) {
                    $this->deleteDirectory($filePath);
                }
            }
        }
    }

    private function deleteDirectory($dir) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_file($filePath)) {
                    unlink($filePath);
                } else if (is_dir($filePath)) {
                    $this->deleteDirectory($filePath);
                }
            }
        }
        rmdir($dir);
    }
}