<?php

use Stradow\Framework\Event\Event;
use Stradow\Framework\Event\ListenerProvider;
use Stradow\Framework\DependencyResolver\Container;

require __DIR__.'/../vendor/autoload.php';

require __DIR__.'/environment.php';

/**
 * @var array EVENT_CONFIG
 */
define('EVENT_CONFIG', require __DIR__ . '/../config/events.php');
Container::add(Event::class, new Event(new ListenerProvider(EVENT_CONFIG)));

/**
 * @var array DB_CONFIG
 */
define('DB_CONFIG', require __DIR__.'/../config/database.php');
require __DIR__.'/databaseAccess.php';

/**
 * @var \Neuralpin\HTTPRouter\Router $Router
 */
$Router = require __DIR__.'/../config/routes.php';

/**
 * @var \Neuralpin\HTTPRouter\Interface\ControllerWrapper $Controller
 */
$Controller = require __DIR__.'/http.php';

define('RENDER_CONFIG', require __DIR__.'/../config/render.php');
define('PUBLIC_DIR', realpath(__DIR__.'/../public'));
define('CONTENT_DIR', __DIR__.'/../content');
define('BASE_DIR', __DIR__.'/..');
