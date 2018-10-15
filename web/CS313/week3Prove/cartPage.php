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
        if (isset($_SESSION["items"])) {
          $totalPrice = 0;
          $totalItems = 0;
          echo "<table>
                  <tr><td><h2><i>Item</i></h2></td>
                      <td><h2><i>Price</i></h2></td>
                      <td><h2><i>Quantity</i></h2></td>
                      <td><h2><i>Got too many?</i></h2></td>
                  </tr>";

          foreach ($_SESSION["items"] as $item_name => $item_quantity) {
            echo "<tr>
                    <td>$item_name</td>
                    <td>\$";
                      $str = file_get_contents('items.json');
                      $json = json_decode($str, true); // decode the JSON into an associative array
                      foreach ($json as $key => $value) {
                        //see the json to php decoder here: http://freeonlinetools24.com/json-decode
                        if ($value['name'] == $item_name) {
                          echo $value['price'];
                          $totalPrice += ($value['price'] * $item_quantity);
                        }
                      } 
                    
                    echo "</td>
                    <td>$item_quantity</td>
                    $totalItems += $item_quantity;
                    
                  </tr>";
          }

          echo "<tr>
                  <td><h2><i>Totals</i></h2></td>
                  <td><h2><i>$totalPrice</i></h2></td>
                  <td><h2><i>$item_quantity Items</i></h2></td>
                </tr>"

          echo "</table>";
        }

    ?>

    <br/><br/>

  </body>
</html>