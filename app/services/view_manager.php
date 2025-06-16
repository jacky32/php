<?php
class ViewManager
{
  private $content;
  private $controller;
  private $action;
  private $title;
  private $controllerData;

  public function __construct()
  {
    $tmp = \debug_backtrace();
    $this->controller = \str_replace("controller", "", \strtolower($tmp[1]['class']));
    $this->action = \str_replace("action", "", \strtolower($tmp[1]['function']));
  }

  public function render($view, $data = [])
  {
    $this->controllerData = extract($data);
    ob_start();
    $this->title = isset($title) ? $title : $this->controller;
    include "app/views/$view.html.php";
    $this->content = ob_get_contents();
    ob_end_clean();
    return $this->content;
  }

  public function __destruct()
  {
    include 'app/views/layouts/application.html.php';
  }


  // public function renderView($variables = null)
  // {
  // \ob_start();
  // require "../{$this->controller}/{$this->action}.html.php";
  // $this->content = \ob_get_clean();
  // }
}
