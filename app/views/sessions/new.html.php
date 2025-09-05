  <?php
  foreach ($users as $user) {
    echo $user->get_username() . "<br>";
    echo $user->get_email() . "<br>";
  }
  echo count($users) . " users found.<br>";
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
  <form action="/login" method="POST">
    Email: <input type="email" name="email"><br>
    Heslo: <input type="password" name="password"><br>
    <input type="submit" value="Odeslat">
  </form>
