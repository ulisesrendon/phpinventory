<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../Config/app.php';

$Controller = require __DIR__.'/../Config/http.php';
echo $Controller->getResponse();
