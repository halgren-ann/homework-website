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
          echo "<table>
                  <tr><td>Item</td>
                      <td>Price</td>
                      <td>Quantity</td>
                  </tr>";

          foreach ($_SESSION["items"] as $item_name => $item_quantity) {
            echo "<tr>
                    <td>$item_name</td>
                    <td>\$" . "document.onload='getItemPrice($item_name)'";
                      $str = file_get_contents('http://example.com/example.json/');
                      $json = json_decode($str, true); // decode the JSON into an associative array
                      foreach ($json as $key => $value) {
                        //see the json to php decoder here: http://freeonlinetools24.com/json-decode
                        if ($value['name'] == $item_name) {
                          echo $value['price'];
                        }
                      } 
                    
            echo "          
                    </td>
                    <td>$item_quantity</td>
                  </tr>";
          }

          echo "</table>";
        }

    ?>

    <br/><br/>

  </body>
</html>