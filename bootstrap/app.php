<?php

use Neuralpin\HTTPRouter\Interface\ControllerWrapper;
use Neuralpin\HTTPRouter\Router;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Event\ListenerProvider;

require __DIR__.'/../vendor/autoload.php';

require __DIR__ . '/environment.php';

/**
 * @var array DB_CONFIG
 */
define('DB_CONFIG', require __DIR__ . '/../config/database.php');
require __DIR__.'/databaseAccess.php';

/**
 * @var array EVENT_CONFIG
 */
define('EVENT_CONFIG', require __DIR__ . '/../config/events.php');
Container::add(ListenerProvider::class, new ListenerProvider(EVENT_CONFIG));

/**
 * @var Router $Router
 */
$Router = require __DIR__.'/../config/routes.php';

/**
 * @var ControllerWrapper $Controller
 */
$Controller = require __DIR__.'/http.php';

define('RENDER_CONFIG', require __DIR__ . '/../config/render.php');