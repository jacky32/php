<html>

<body>

  <?php
  $servername = "localhost:3307";
  $username = "root";
  $password = "abcd";
  $dbname = "php_app";

  // Try to connect to the database
  try {
    // First try to connect to the specific database
    $conn = new mysqli($servername, $username, $password, $dbname);
  } catch (mysqli_sql_exception $e) {
    // If the database doesn't exist, create it
    $conn = new mysqli($servername, $username, $password);

    $sql = "CREATE DATABASE IF NOT EXISTS php_app;";
    if ($conn->query($sql) === TRUE) {
      echo "Database created successfully<br>";

      // Close connection and reconnect to the new database
      $conn->close();
      $conn = new mysqli($servername, $username, $password, $dbname);
      echo "Connected to new database<br>";
    } else {
      die("Error creating database: " . $conn->error);
    }
  }

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if the table exists before trying to create it
  $tableExistsQuery = "SHOW TABLES LIKE 'Posts'";
  $tableExists = $conn->query($tableExistsQuery)->num_rows > 0;

  $sql = "CREATE TABLE IF NOT EXISTS Posts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    body VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

  if ($conn->query($sql) === TRUE) {
    if (!$tableExists) {
      echo "Posts table created successfully<br>";
    }
  } else {
    echo "Error creating table Posts: " . $conn->error;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO Posts (body) VALUES (?)");
    $stmt->bind_param("s", $_POST["body"]);

    if ($stmt->execute()) {
      echo "New post created successfully<br>";
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
  }

  $sql = "SELECT id, body FROM Posts";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo "<br> id: " . $row["id"] . " - body: " . $row["body"] . "<br>";
    }
  } else {
    echo "0 results";
  }

  $conn->close();
  ?>

  <form action="posts.php" method="POST">
    Text: <input type="text" name="body"><br>
    <input type="submit" value="Odeslat">
  </form>
</body>

</html>
