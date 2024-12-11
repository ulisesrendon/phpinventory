<?php

use Neuralpin\HTTPRouter\ResponseRender;
use Neuralpin\HTTPRouter\Interface\ControllerWrapper;

require __DIR__.'/../bootstrap/app.php';

try{
    /**
     * @var ControllerWrapper $Controller
     * @var ResponseRender $Response
     */
    $Response = $Controller->getResponse();
}catch(\Throwable|\Exception $Error){
    $Error = (string) $Error;
    echo "<pre>$Error</pre>";
    exit();
}

echo $Response;
