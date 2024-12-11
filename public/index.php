<?php

use Neuralpin\HTTPRouter\Response;


require __DIR__.'/../bootstrap/app.php';

try {
    /**
     * @var \Neuralpin\HTTPRouter\Interface\ControllerWrapper $Controller
     * @var \Neuralpin\HTTPRouter\ResponseRender $Response
     */
    $Response = $Controller->getResponse();
} catch (\Throwable|\Exception $Error) {
    if (1 == $_ENV['APP_DEBUG']) {
        $Response = "<pre>{$Error}</pre>";
    } else {
        $Response = Response::template(__DIR__ . '/500.html', 500);
    }
    
}

echo $Response;
