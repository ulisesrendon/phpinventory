<?php

namespace Lib\Http;

class TextRender
{
    public function __construct(
        public string $filepath,
        public array $context = []
    ) {
        if (! file_exists($this->filepath)) {
            throw new \Exception('File not found: '.$this->filepath);
        }
    }

    public function render()
    {
        ob_start();
        extract($this->context);
        require $this->filepath;

        return ob_get_clean();
    }

    public function __toString()
    {
        return $this->render();
    }
}
