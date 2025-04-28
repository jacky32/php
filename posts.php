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

  $tableExistsQuery = "SHOW TABLES LIKE 'Comments'";
  $tableExists = $conn->query($tableExistsQuery)->num_rows > 0;

  $sql = "CREATE TABLE IF NOT EXISTS Comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT(6) UNSIGNED NOT NULL,
    body VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE
  );";

  if ($conn->query($sql) === TRUE) {
    if (!$tableExists) {
      echo "Comments table created successfully<br>";
    }
  } else {
    echo "Error creating table Comments: " . $conn->error;
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

  $sql = "SELECT post.id, post.body, post.created_at, comment.id as comment_id, comment.body as comment_body, comment.created_at as comment_created_at
          FROM Posts post
          LEFT JOIN Comments comment ON post.id = comment.post_id
          ORDER BY post.id, comment.id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $currentPostId = null;
    $postDiv = null;

    // output data of each row
    while ($row = $result->fetch_assoc()) {
      if ($currentPostId !== $row["id"]) {
        // Start a new post
        if ($postDiv !== null) {
          $postDiv .= "</div>";
          echo $postDiv;
        }

        $currentPostId = $row["id"];
        $postDiv = "<div style='border: 1px solid black; margin-bottom: 10px; padding: 10px;'>";
        $postDiv .= "<div><strong>Příspěvek #" . $row["id"] . "</strong>: " . date('d. m. Y H:i:s', strtotime($row["created_at"])) . "</div>";
        $postDiv .= "<div>" . $row["body"] . "</div>";
        $postDiv .= "<div style='margin-top: 5px;'><strong>Komentáře:</strong></div>";

        $postDiv .= "<form action='comments.php' method='POST'>";
        $postDiv .= "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
        $postDiv .= "Text: <input type='text' name='body'><br>";
        $postDiv .= "<input type='submit' value='Odeslat'>";
        $postDiv .= "</form>";
      }

      // Add comment if it exists
      if (!is_null($row["comment_id"])) {
        $comment_date = date('d. m. Y H:i:s', strtotime($row["comment_created_at"]));
        $postDiv .= "<div style='margin-left: 30px; border-left: 2px solid #ccc; padding-left: 10px;'>"
          . $comment_date . " - " . $row["comment_body"] . "</div>";
      } else {
        $postDiv .= "<div style='margin-left: 30px; border-left: 2px solid #ccc; padding-left: 10px;'>Bez komentářů</div>";
      }
    }

    // Output the last post
    if ($postDiv !== null) {
      $postDiv .= "</div>";
      echo $postDiv;
    }
  } else {
    echo "0 příspěvků";
  }

  $conn->close();
  ?>

  <form action="posts.php" method="POST">
    Text: <input type="text" name="body"><br>
    <input type="submit" value="Odeslat">
  </form>
</body>

</html>
