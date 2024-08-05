<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../Config/app.php';

$Response = require __DIR__.'/../Config/http.php';
echo $Response->render();