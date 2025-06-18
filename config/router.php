<?php
class Router
{
  public $controllerName;
  public $action;

  public function __construct()
  {
    $routeAction = $_SERVER["REQUEST_URI"];
    if (isset($_GET['action'])) {
      $routeAction = $_GET['action'];
    }
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($routeAction) {
      case '/posts':
        switch ($requestMethod) {
          case 'GET':
            $this->controllerName = 'PostsController';
            $this->action = 'index';
            break;
          case 'POST':
            $this->controllerName = 'PostsController';
            $this->action = 'create';
            break;
        }
        break;
      default:
        $this->controllerName = 'HomeController';
        $this->action = 'index';
        break;
    }
  }
}
