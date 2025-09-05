<?php
require "app/controllers/application_controller.php";
require 'app/services/view_manager.php';

class ErrorsController extends ApplicationController
{


  public function __construct()
  {
    parent::__construct();
  }


  public function notFound($request)
  {
    $this->viewManager->render("layouts/errors/404", []);
  }
}
