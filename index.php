<?php
$appConfig = require './config/application.php';
require 'config/router.php';
require 'app/services/database.php';

function toSnakeCase($input)
{
  return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
}

// router
$router = new Router();

$controllerName = $router->controllerName;
$action = $router->action;

require 'app/controllers/' . toSnakeCase($controllerName)  . '.php';

// Uncomment to reset DB schema
// ScriptManager::loadSchema($appConfig['connection'], true);

$db = new Database($appConfig);
$dbConnection = null;
if ($db) {
  $dbConnection = $db->getConnection();
}

$controller = new $controllerName($dbConnection);
$controller->{$action}($_REQUEST);
