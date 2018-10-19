<?php
    session_start();
    // define variables and set to empty values
    $apt = $street = $city = $state = $zip = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $apt = test_input($_POST["apt"]);
      $street = test_input($_POST["street"]);
      $city = test_input($_POST["city"]);
      $state = test_input($_POST["state"]);
      $zip = test_input($_POST["zip"]);
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
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
    <h1 class="centered">Confirmation Page</h1>

    <?php
        if (isset($_SESSION["items"])) {
          $totalItems = 0;
          $totalPrice = 0.00;
          echo "
                <h2>The items below will be sent to the following address:</h2>
                <p>" . $apt . " " . $_POST["street"] . "</p>
                <p>" . $_POST["city"] . ", " . $_POST["state"] . " " . $_POST["zip"] . "</p>
                ";

          echo "<table>
                  <tr><td><h2><i>Item</i></h2></td>
                      <td><h2><i>Price</i></h2></td>
                      <td><h2><i>Quantity</i></h2></td>
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
          }

          echo "<tr>
                <td><h2><i>Totals</i></h2></td>
                <td><h2><i>\$$totalPrice</i></h2></td>
                <td><h2><i>$totalItems</i></h2></td>
              </tr>
            </table>";
        }

    ?>

    <br/><br/>

  </body>
</html>