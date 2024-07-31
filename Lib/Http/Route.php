<?php
namespace Lib\Http;

class Route
{
    public string $regexp;

    public function __construct(
        public string $method,
        public string $path,
        public object|array $controller,
    )
    {
        $regexp = preg_replace('/:([a-zA-Z0-9]+)/', '([^/]+)', $path);
        $this->regexp = '/^' . str_replace('/', '\/', $regexp) . '$/';

        $this->method = strtolower($this->method);
    }

    public function execute(RequestData $RequestData, array $Params)
    {
        // [TODO] Improve controller validation
        if(is_array($this->controller)){
            $this->controller = [new $this->controller[0]($RequestData), $this->controller[1]];
        }

        return call_user_func_array($this->controller, $Params);
    }
}