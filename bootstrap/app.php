<?php

use Dotenv\Dotenv;
use Neuralpin\HTTPRouter\Interface\ControllerWrapper;
use Neuralpin\HTTPRouter\Router;
use Stradow\Framework\Database\DataBaseAccess;
use Stradow\Framework\DependencyResolver\Container;
use Stradow\Framework\Event\ListenerProvider;

require __DIR__.'/../vendor/autoload.php';

require __DIR__ . '/environment.php';

define('DB_CONFIG', require __DIR__.'/../config/database.php');

/**
 * @var DataBaseAccess
 */
$DataBaseAccess = require __DIR__.'/databaseAccess.php';

/**
 * @var array
 */
define('EVENT_CONFIG', require __DIR__.'/../config/events.php');
$ListenerProvider = new ListenerProvider(EVENT_CONFIG);
Container::add(ListenerProvider::class, $ListenerProvider);

/**
 * @var Router
 */
$Router = require __DIR__.'/../config/routes.php';

/**
 * @var ControllerWrapper
 */
$Controller = require __DIR__.'/http.php';
