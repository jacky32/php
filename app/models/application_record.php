<?php
class ApplicationRecord
{
  protected $db;
  protected $connection;
  protected $attributes = [];

  public function __construct()
  {
    $this->db = new Database();
    $this->connection = $this->db->getConnection();
  }

  public function __destruct()
  {
    $this->closeConnection();
  }

  public function __call($method, $arguments)
  {
    // Handle set_* methods
    if (strpos($method, 'set_') === 0) {
      $property = substr($method, 4);
      $this->attributes[$property] = $arguments[0];
      return $this;
    }

    // Handle get_* methods
    if (strpos($method, 'get_') === 0) {
      $property = substr($method, 4);
      return $this->attributes[$property] ?? null;
    }

    throw new Exception("Method $method does not exist");
  }

  public function getConnection()
  {
    return $this->connection;
  }

  public function closeConnection()
  {
    if ($this->connection) {
      $this->connection->close();
    }
  }
}
