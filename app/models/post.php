<?php
require "app/models/application_record.php";
class Post extends ApplicationRecord
{
  private $body;

  // Methods
  function set_body($body)
  {
    $this->body = $body;
  }
  function get_body()
  {
    return $this->body;
  }

  public static function all()
  {
    $posts = [];
    $query = "SELECT * FROM posts";
    $database = new Database();
    $result = $database->getConnection()->query($query);

    while ($row = $result->fetch_assoc()) {
      $post = new Post(["body" => $row['body']]);
      $posts[] = $post;
    }

    return $posts;
  }

  public static function add() {}
}
