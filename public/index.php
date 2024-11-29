<?php

use Neuralpin\HTTPRouter\ResponseRender;

require __DIR__.'/../bootstrap/app.php';

/**
 * @var ResponseRender $Response
 */
try{
    $Response = $Controller->getResponse();
}catch(\Throwable|\Exception $Error){
    $Error = (string) $Error;
    echo "<pre>$Error</pre>";
    exit();
}
echo $Response;
