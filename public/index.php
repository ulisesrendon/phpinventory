<?php

use Neuralpin\HTTPRouter\ControllerWrapped;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../config/app.php';

/**
 * @var ControllerWrapped
 */
$Controller = require __DIR__.'/../config/http.php';
echo $Controller->getResponse();
