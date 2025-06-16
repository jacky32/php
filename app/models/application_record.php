<?php
class ApplicationRecord
{
  protected $db;
  protected $connection;

  public function __construct($config)
  {
    $this->db = new Database();
    $this->connection = $this->db->getConnection();
  }

  public function __destruct()
  {
    $this->closeConnection();
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
