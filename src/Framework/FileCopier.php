<?php
namespace Stradow\Framework;

use Exception;
class FileCopier {
    private $sourceDir;
    private $targetDir;

    public function __construct($sourceDir, $targetDir) {
        $this->sourceDir = rtrim($sourceDir, '/\\') . DIRECTORY_SEPARATOR;
        $this->targetDir = rtrim($targetDir, '/\\') . DIRECTORY_SEPARATOR;
    }

    public function copyFiles() {
        if (!is_dir($this->sourceDir)) {
            throw new Exception("Source directory does not exist: " . $this->sourceDir);
        }

        if (!is_dir($this->targetDir)) {
            if (!mkdir($this->targetDir, 0777, true)) {
                throw new Exception("Failed to create target directory: " . $this->targetDir);
            }
        }

        $this->copyDirectory($this->sourceDir, $this->targetDir);
    }

    private function copyDirectory($source, $target) {
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $src = $source . $file;
                $dst = $target . $file;
                if (is_dir($src)) {
                    if (!is_dir($dst)) {
                        mkdir($dst);
                    }
                    $this->copyDirectory($src . DIRECTORY_SEPARATOR, $dst . DIRECTORY_SEPARATOR);
                } else {
                    if (!copy($src, $dst)) {
                        throw new Exception("Failed to copy file: " . $file);
                    }
                }
            }
        }
    }
}