<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sewing Shop</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="script.js"></script>
  </head>
  <body>
    <h1 class="centered">Welcome to the sewing shop :)</h1>
    <p class="centered">Take a look around. We hope you find something you like!</p>

    <a id="returnToShopping" href="index.php"><= Shop More</a>
    <br/><br/>

    <?php
        print_r($_SESSION);
    ?>

    <br/><br/>

  </body>
</html>