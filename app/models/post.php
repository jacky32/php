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

  function validate()
  {
    if ($this->get_body() == null) throw new Exception("Body cannot be null");
    if (strlen($this->get_body()) > 255) throw new Exception("Body cannot be longer than 255 characters");
  }

  function save()
  {
    $this->validate();
    $sql = "INSERT INTO posts (body) VALUES ('" . $this->get_body() . "');";
    $this->connection->query($sql);
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
