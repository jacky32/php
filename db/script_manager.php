<?php
class ScriptManager
{
  public static function connectToDatabase($connectionParams)
  {
    $db = new mysqli(
      $connectionParams['host'],
      $connectionParams['user'],
      $connectionParams['password'],
      $connectionParams['dbname']
    );

    if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
    }

    return $db;
  }

  public static function loadSchema($connectionParams)
  {
    $output = [];
    $conn = ScriptManager::connectToDatabase($connectionParams);
    if ($conn->connect_error) {
      throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE DATABASE " . $connectionParams['dbname'];
    if ($conn->query($sql) === TRUE) {
      echo "Database created successfully";
    } else {
      $output[] = "<br />Error creating database: " . $conn->error;
    }

    $conn = ScriptManager::connectToDatabase($connectionParams);
    $conn->store_result();
    $sql = file_get_contents('./schema.sql');
    if (mysqli_multi_query($conn, $sql)) {
      $output[] = "<br />SQL installation script is executed successfully";
    } else {
      throw new \Exception("Error of database setting up: " . $conn->error);
    }
    $conn->close();
  }
}
