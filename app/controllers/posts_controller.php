<?php
require "app/controllers/application_controller.php";
require 'app/models/post.php';
require 'app/services/view_manager.php';

class PostsController extends ApplicationController
{
  private $post;

  public function __construct($postModel)
  {
    parent::__construct();
    $this->post = $postModel;
  }


  public function index($request)
  {
    $this->viewManager->render("posts/index", [
      "posts" => Post::all()
    ]);
  }

  public function create($request)
  {
    try {
      if (isset($request['body'])) {
        $post = new Post(['body' => $request['body']]);
        $post->save();
      }
      header("Location: /posts");
    } catch (Exception $e) {
      $errors[] = $e->getMessage();
      $this->viewManager->render("posts/index", [
        "posts" => Post::all(),
        "errors" => $errors,
      ]);
    }
  }
}
