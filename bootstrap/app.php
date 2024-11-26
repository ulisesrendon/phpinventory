<?php

use Dotenv\Dotenv;
use Neuralpin\HTTPRouter\Router;
use App\Framework\Event\ListenerProvider;
use App\Framework\Database\DataBaseAccess;
use App\Framework\DependencyResolver\Container;
use Neuralpin\HTTPRouter\Interface\ControllerWrapper;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();
$dotenv->ifPresent('APP_DEBUG')->isBoolean();

if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] == 1) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

define('DB_CONFIG', require __DIR__.'/../config/database.php');

/**
 * @var DataBaseAccess
 */
$DataBaseAccess = require __DIR__ . '/../bootstrap/databaseAccess.php';

/**
 * @var array
 */
define('EVENT_CONFIG', require __DIR__ . '/../config/events.php');
$ListenerProvider = new ListenerProvider(EVENT_CONFIG);
Container::add(ListenerProvider::class, $ListenerProvider);

/**
 * @var Router
 */
$Router = require __DIR__ . '/../config/routes.php';

/**
 * @var ControllerWrapper
 */
$Controller = require __DIR__ . '/../bootstrap/http.php';
