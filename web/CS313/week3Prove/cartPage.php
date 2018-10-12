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
    <h1 class="centered">Your Cart</h1>
    <p class="centered">Did you get everything?</p>
    <br/><br/>

    <a id="returnToShopping" href="index.php">Shop More</a>
    <br/><br/>

    <?php
        print_r($_SESSION);

        if (isset($_SESSION["items"])) {
            foreach($item in $_SESSION["items"]) {
            echo key($item);
            echo $item;
          }
        }

    ?>

    <br/><br/>

  </body>
</html>