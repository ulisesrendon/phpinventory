<?php

namespace Lib\Http\Helper;

use Stringable;

class TextRender implements Stringable
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
