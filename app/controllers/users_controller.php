<?php

require "app/controllers/application_controller.php";
require 'app/models/user.php';
require 'app/services/view_manager.php';


class UsersController extends ApplicationController
{
  private $user;

  public function __construct($userModel)
  {
    parent::__construct();
    $this->user = $userModel;
  }

  public function new($request)
  {
    $this->render("registrations/new", [
      "users" => \User::all()
    ]);
  }

  public function create($request)
  {
    // TODO: CSRF
    // if (!empty($_POST['token'])) {
    //   if (hash_equals($_SESSION['token'], $_POST['token'])) {

    //   } else {

    //   }
    // }

    // try {
    //   $user = new \User();
    //   if (isset($request['name'])) {
    //     $user->set_name($request['name']);
    //   }
    //   if (isset($request['email'])) {
    //     $user->set_email($request['email']);
    //   }
    //   $user->save();
    try {
      $this->auth->register($_POST['email'], $_POST['password'], $_POST['username']);
      // , function ($selector, $token) {
      //   echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
      //   echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
      //   echo '  For SMS, consider using a third-party service and a compatible SDK';
      // });
    } catch (\Delight\Auth\InvalidEmailException $e) {
      $this->addFlash('error', "Neplatný email");
      header("Location: /registration");
      die();
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      $this->addFlash('error', "Neplatné heslo");
      header("Location: /registration");
      die();
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
      $this->addFlash('error', "Uživatel již existuje");
      header("Location: /registration");
      die();
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      $this->addFlash('error', "Příliš mnoho pokusů");
      header("Location: /registration");
      die();
    }
    // header("Location: /registration/new");
    $this->addFlash('success', "Úspěšně zaregistrován");
    header("Location: /login");
    // } catch (\Exception $e) {
    //   $errors[] = $e->getMessage();
    //   $this->render("registrations/new", [
    //     "users" => \User::all(),
    //     "errors" => $errors,
    //   ]);
    // }
  }
}
