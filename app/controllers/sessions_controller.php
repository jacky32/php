<?php

require "app/controllers/application_controller.php";
require 'app/models/user.php';
require 'app/services/view_manager.php';

class SessionsController extends ApplicationController
{
  private $user;

  public function __construct($userModel)
  {
    parent::__construct();
    $this->user = $userModel;
  }


  public function new($request)
  {
    if ($this->auth->isLoggedIn()) {
      $this->addFlash('info', "Již přihlášen");
      header("Location: /");
    } else {
      $this->render("sessions/new", [
        "users" => \User::all()
      ]);
    }
  }

  public function create($request)
  {
    try {
      $this->auth->login($_POST['email'], $_POST['password']);
    } catch (\Delight\Auth\InvalidEmailException $e) {
      die('Wrong email address');
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      die('Wrong password');
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
      die('Email not verified');
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      die('Too many requests');
    }
    $this->addFlash('success', "Úspěšně přihlášen");
    // try {
    // $user = new \User();
    // if (isset($request['name'])) {
    //   $user->set_name($request['name']);
    // }
    // if (isset($request['email'])) {
    //   $user->set_email($request['email']);
    // }
    // $user->save();
    // header("Location: /login");
    // } catch (\Exception $e) {
    //   $errors[] = $e->getMessage();
    //   $this->render("sessions/index", [
    //     "users" => \User::all(),
    //     "errors" => $errors,
    //   ]);
    // }
  }

  public function destroy($request)
  {
    $this->auth->logout();
    $this->addFlash('success', "Úspěšně odhlášen");
    header("Location: /");
  }
}
