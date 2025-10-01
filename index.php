<?php
$appConfig = require './config/application.php';
require 'config/router.php';
require 'app/services/database.php';
require 'lib/helpers.php';
require __DIR__ . '/vendor/autoload.php';

// Uncomment to reset DB schema
// ScriptManager::loadSchema($appConfig['connection'], true);
// Uncomment to load DB and tables without dropping existing DB
ScriptManager::loadSchema($appConfig['connection']);

// router
$router = new Router();

$controllerName = $router->controllerName;
$action = $router->action;

require 'app/controllers/' . toSnakeCase($controllerName)  . '.php';

// // CSRF token
// session_start();
// if (empty($_SESSION['token'])) {
//   $_SESSION['token'] = bin2hex(random_bytes(32));
// }
// $token = $_SESSION['token'];

$db = new Database($appConfig);
$dbConnection = null;
if ($db) {
  $dbConnection = $db->getConnection();
}

$controller = new $controllerName($dbConnection);
$controller->{$action}($_REQUEST);
