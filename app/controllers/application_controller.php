<?php
class ApplicationController
{
  protected $errors = [];
  protected $viewManager;

  public function __construct()
  {
    $this->viewManager = new ViewManager();
  }
}
