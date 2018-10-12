<?php
    session_start();
    if (isset($_POST["item"])) {
        $name = $_POST["item"];
        if (isset($_SESSION["items"][$name])) {
            $_SESSION["items"][$name]++;
        }
        else {
            $_SESSION["items"][$name] = 1;
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

    <h1 class="centered">Welcome to the sewing shop :)</h1>
    <p class="centered">Take a look around. We hope you find something you like!</p>
    <br/><br/><br/>
    <form action="index.php" method="post">
        <table>
            <tr>
                <td class="col1">
                    <img src="fabric.jpg"/>
                    <button name="item" value="fabric" type="submit" onclick="addToCart('fabric')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('fabric')">Item Details</button>
                </td>
                <td class="col2">
                    <img src="mat.jpg"/>
                    <button  action = "<?php $_SESSION["mat"] = 8.99; ?>" onclick="addToCart('mat')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('mat')">Item Details</button>
                </td>
                <td class="col3">
                    <img src="cutter.png"/>
                    <button  action = "<?php $_SESSION["rotary"] = 5.99; ?>" onclick="addToCart('rotary')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('rotary')">Item Details</button>
                </td>
                <td class="col4">
                    <img src="ruler.jpg"/>
                    <button  action = "<?php $_SESSION["ruler"] = 12.99; ?>" onclick="addToCart('ruler')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('ruler')">Item Details</button>
                </td>
            </tr>
            <tr>
                <td class="col1">
                    <img src="batting.png"/>
                    <button  action = "<?php $_SESSION["batting"] = 17.99; ?>" onclick="addToCart('batting')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('batting')">Item Details</button>
                </td>
                <td class="col2">
                    <img src="needles.jpg"/>
                    <button  action = "<?php $_SESSION["needles"] = 9.99; ?>" onclick="addToCart('needles')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('needles')">Item Details</button>
                </td>
                <td class="col3">
                    <img src="pins.jpg"/>
                    <button  action = "<?php $_SESSION["pins"] = 2.99; ?>" onclick="addToCart('pins')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('pins')">Item Details</button>
                </td>
                <td class="col4">
                    <img src="machine.jpg"/>
                    <button  action = "<?php $_SESSION["machine"] = 144.99; ?>" onclick="addToCart('machine')">Add to Cart</button>
                    <br/>
                    <button onclick="getDetails('machine')">Item Details</button>
                </td>
            </tr>
        </table>
    </form>
    
    <br/><br/><br/>

    <img src="cart.png" id="cartImage"/>
    <a id="viewCartButton" href="cartPage.php">View Cart</a>

    <br/><br/>
    <div id="snackbar">This item was added to your cart</div>

  </body>
</html>