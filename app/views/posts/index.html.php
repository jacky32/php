  <?php
  foreach ($posts as $post) {
    echo $post->get_body() . "<br>";
  }
  echo count($posts) . " posts found.<br>";
  ?>

  <form action="/posts" method="POST">
    Text: <input type="text" name="body"><br>
    <input type="submit" value="Odeslat">
  </form>
