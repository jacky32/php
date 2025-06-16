<?php
require "app/models/application_record.php";
class Post extends ApplicationRecord
{
  private $body;

  public function __construct($data = [])
  {
    parent::__construct($data);
    if (isset($data['body'])) {
      $this->set_body($data['body']);
    }
  }

  // Methods
  function set_body($body)
  {
    $this->body = $body;
  }
  function get_body()
  {
    return $this->body;
  }

  function save()
  {
    $sql = "INSERT INTO posts (body) VALUES ('" . $this->get_body() . "');";
    $database = new Database();
    $connection = $database->getConnection();
    $connection->query($sql);
  }

  public static function all()
  {
    $posts = [];
    $sql = "SELECT * FROM posts;";
    $database = new Database();
    $connection = $database->getConnection();
    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
      $post = new Post(["body" => $row['body']]);
      $posts[] = $post;
    }

    return $posts;
  }

  public static function add() {}
}
