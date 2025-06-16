<?php
class ApplicationRecord
{
  protected $connection;

  public function __construct($config)
  {
    $this->connection = new mysqli(
      $config['connection']['host'],
      $config['connection']['user'],
      $config['connection']['password'],
      $config['connection']['dbname'],
      $config['connection']['port']
    );

    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
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
