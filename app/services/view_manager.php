<?php
class ViewManager
{
  private $content;
  private $controller;
  private $action;
  private $title;

  public function __construct()
  {
    $tmp = \debug_backtrace();
    $this->controller = \str_replace("controller", "", \strtolower($tmp[1]['class']));
    $this->action = \str_replace("action", "", \strtolower($tmp[1]['function']));
  }

  public function render($view, $data = [])
  {
    extract($data);
    $this->content = require "app/views/$view.html.php";
  }

  public function __destruct()
  {
    include 'views/layouts/application.html.php';
  }


  public function renderView($variables = null)
  {
    \ob_start();
    require "../{$this->controller}/{$this->action}.html.php";
    $this->content = \ob_get_clean();
  }
}
