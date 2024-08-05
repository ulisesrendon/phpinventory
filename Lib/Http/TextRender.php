<?php

namespace Lib\Http;

class TextRender
{
    public function __construct(
        public string $content,
        public array $context = []
    ) {}

    public function render()
    {
        ob_start();
        extract($this->context);
        echo $this->content;

        return ob_get_clean();
    }

    public function __toString()
    {
        return $this->render();
    }
}
