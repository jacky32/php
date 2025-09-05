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
    $this->viewManager->render("registrations/new", [
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
      $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username']);
      // , function ($selector, $token) {
      //   echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
      //   echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
      //   echo '  For SMS, consider using a third-party service and a compatible SDK';
      // });

      echo 'We have signed up a new user with the ID ' . $userId;
    } catch (\Delight\Auth\InvalidEmailException $e) {
      die('Invalid email address');
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      die('Invalid password');
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
      die('User already exists');
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      die('Too many requests');
    }
    header("Location: /registration/new");
    // } catch (\Exception $e) {
    //   $errors[] = $e->getMessage();
    //   $this->viewManager->render("registrations/new", [
    //     "users" => \User::all(),
    //     "errors" => $errors,
    //   ]);
    // }
  }
}
