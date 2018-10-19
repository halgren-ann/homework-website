<?php
    session_start();
    if (isset($_POST["item"])) {
      $name = $_POST["item"];
      if (isset($_SESSION["items"][$name])) {
        $_SESSION["items"][$name]--;
        if ($_SESSION["items"][$name] == 0) {
          unset($_SESSION["items"][$name]);
        }
      }
    }
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
          $totalItems = 0;
          $totalPrice = 0.00;

          echo "<table>
                  <tr><td><h2><i>Item</i></h2></td>
                      <td><h2><i>Price</i></h2></td>
                      <td><h2><i>Quantity</i></h2></td>
                      <td><h2><i>Got Too Many?</i></h2></td>
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
                          $totalPrice = $totalPrice + ($value['price'] * $item_quantity);
                        }
                      } 
                    
                    echo "</td>
                    <td>$item_quantity</td>";
                    $totalItems = $totalItems + $item_quantity;

                    echo "<td>
                      <form action='cartPage.php' method='post'>
                      <button type='submit' name='item' value='$item_name'>Remove one item</button>
                      </form>
                    </td>
                  </tr>";
          }

          

          echo "<tr>
                <td><h2><i>Totals</i></h2></td>
                <td><h2><i>\$$totalPrice</i></h2></td>
                <td><h2><i>$totalItems</i></h2></td>
                <td>
                  <a href='checkout.php'><button id='proceedToCheckout'>Proceed to checkout</button></a>
                </td>
              </tr>
            </table>";
        }

    ?>

    <br/><br/>

  </body>
</html>