<?php
require "app/controllers/application_controller.php";
require 'app/models/post.php';
require 'app/services/view_manager.php';

class PostsController extends ApplicationController
{
    private $post;

    public function __construct($postModel)
    {
        $this->post = $postModel;
    }


    public function index($request)
    {
        $View = new ViewManager();
        $View->render("posts/index", [
            "posts" => Post::all()
        ]);
    }
}
