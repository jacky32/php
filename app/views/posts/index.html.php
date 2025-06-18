  <?php
  foreach ($posts as $post) {
    echo $post->get_body() . "<br>";
  }
  echo count($posts) . " posts found.<br>";
  ?>

  <?php
  if (isset($errors) && count($errors) > 0) {
    echo "<div class='error'>";
    foreach ($errors as $error) {
      echo $error . "<br>";
    }
    echo "</div>";
  }
  ?>
  <form action="/posts" method="POST">
    Text: <input type="text" name="body"><br>
    <input type="submit" value="Odeslat">
  </form>
