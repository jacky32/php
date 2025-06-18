<?php
require "app/controllers/application_controller.php";
require 'app/services/view_manager.php';

class HomeController extends ApplicationController
{
  public function __construct()
  {
    parent::__construct();
  }


  public function index($request)
  {
    $this->viewManager->render("home/index", []);
  }
}
