<html>

<title><?php echo $this->title; ?></title>

<body>
  <?php
  if ($this->auth->isLoggedIn()) {
    echo 'User ' . $this->auth->getUsername() . ' is signed in';
  } else {
    echo 'User is not signed in yet';
  }
  ?>
  <?php

  if (FlashManager::hasFlashes()) {
    $flashes = FlashManager::getFlashes();
    foreach ($flashes as $type => $messages) {
      echo "<div class='flash flash-$type' style='background-color: lightgreen; padding: 10px; margin-bottom: 10px;'>";
      foreach ($messages as $message) {
        echo $message . "<br>";
      }
      echo "</div>";
    }
  }
  ?>
  <ul>
    <li><a href="/">Domů</a></li>
    <li><a href="/posts">Příspěvky</a></li>
    <?php
    if ($this->auth->isLoggedIn()) {
      echo '<form action="/logout" method="POST">
                <button type="submit">Odhlásit</button>
            </form>
            ';
    } else {
      echo '<li><a href="/login">Přihlásit</a></li>';
    }
    ?>
  </ul>
  <?php echo $this->content; ?>
</body>

</html>
