<?php
$servername = "localhost:3307";
$username = "root";
$password = "abcd";
$dbname = "php_app";

/**
 * Saves a new comment to the database
 *
 * @param int $postId The ID of the post being commented on
 * @param string $commentBody The content of the comment
 * @return bool True if the comment was saved successfully, false otherwise
 */
function saveComment($postId, $commentBody)
{
  global $servername, $username, $password, $dbname;

  // Connect to the database
  try {
    $conn = new mysqli($servername, $username, $password, $dbname);
  } catch (mysqli_sql_exception $e) {
    return false;
  }

  // Check connection
  if ($conn->connect_error) {
    return false;
  }

  // Prepare and execute the statement
  $stmt = $conn->prepare("INSERT INTO Comments (post_id, body) VALUES (?, ?)");
  $stmt->bind_param("is", $postId, $commentBody);

  $success = $stmt->execute();

  // Close resources
  $stmt->close();
  $conn->close();

  return $success;
}

// Handle form submission if this script is called directly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["post_id"]) && isset($_POST["body"])) {
    $postId = (int)$_POST["post_id"];
    $commentBody = $_POST["body"];

    if (saveComment($postId, $commentBody)) {
      // Redirect back to posts page on success
      header("Location: posts.php");
      exit;
    } else {
      echo "Error: Could not save comment.";
    }
  } else {
    echo "Error: Missing required fields.";
  }
}
