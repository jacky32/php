<?php
class Router
{
  public $controllerName;
  public $action;

  private function isGet()
  {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
  }

  private function isPost()
  {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
  }

  public function __construct()
  {
    $routeAction = $_SERVER["REQUEST_URI"];
    if (isset($_GET['action'])) {
      $routeAction = $_GET['action'];
    }
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    // OPTIMIZE: pattern matching in php ???
    switch ($routeAction) {
      case '/login':
        $this->controllerName = 'SessionsController';
        $this->action = $this->isGet() ? 'new' : 'create';
        break;
      case '/logout':
        $this->controllerName = 'SessionsController';
        if ($this->isPost()) {
          $this->action = 'destroy';
          break;
        }
      case '/registration':
        $this->controllerName = 'UsersController';
        switch ($requestMethod) {
          case 'GET':
            $this->action = 'new';
            break;
          case 'POST':
            $this->action = 'create';
            break;
        }
        break;
      case '/posts/destroy':
        $this->controllerName = 'PostsController';
        switch ($requestMethod) {
          case 'POST':
            $this->action = 'destroy';
            break;
        }
        break;
      case '/posts':
        $this->controllerName = 'PostsController';
        switch ($requestMethod) {
          case 'GET':
            $this->action = 'index';
            break;
          case 'POST':
            $this->action = 'create';
            break;
        }
        break;
      case '/':
        $this->controllerName = 'HomeController';
        $this->action = 'index';
        break;
      default:
        $this->controllerName = 'ErrorsController';
        $this->action = 'notFound';
        break;
    }
    // echo "Routing to " . $this->controllerName . "->" . $this->action . "<br>";
  }
}
