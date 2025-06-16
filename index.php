<?php
$appConfig = require './config/application.php';

function toSnakeCase($input)
{
  return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
}

$routeAction = $_SERVER["REQUEST_URI"];
if (isset($_GET['action'])) {
  $routeAction = $_GET['action'];
}

// router
switch ($routeAction) {
  default:
    $controllerName = 'PostsController';
    $action = 'index';
    break;
}

require 'app/controllers/' . toSnakeCase($controllerName)  . '.php';
require 'app/services/database.php';

$db = new Database($appConfig);
$dbConnection = null;
if ($db) {
  $dbConnection = $db->getConnection();
}

$controller = new $controllerName($dbConnection);
$controller->{$action}($_REQUEST);
