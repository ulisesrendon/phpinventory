<?php

use Lib\Http\ControllerWrapped;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../Config/app.php';

/**
 * @var ControllerWrapped
 */
$Controller = require __DIR__.'/../Config/http.php';
echo $Controller->getResponse();
