<html>

<head>
  <title><?php echo $this->title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class='flex flex-col h-screen'>
  <?php
  // if ($this->auth->isLoggedIn()) {
  //   echo 'User ' . $this->auth->getUsername() . ' is signed in';
  // } else {
  //   echo 'User is not signed in yet';
  // }
  ?>
  <?php require '_menu.html.php'; ?>
  <?php require '_flash.html.php'; ?>
  <main class='grow'>
    <?php echo $this->content; ?>
  </main>
</body>

</html>
