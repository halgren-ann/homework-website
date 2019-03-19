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
    <table>
        <tr>
            <td class="col1">
            <div>
                <h2 class="centered">Fabric</h2>
                <img src="fabric.jpg"/><br/>
                <button onclick="addToCart('fabric')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('fabric')">Item Details</button>
            </div>
            </td>
            <td class="col2">
            <div>
                <h2 class="centered">Cutting Mat</h2>
                <img src="mat.jpg"/><br/>
                <button onclick="addToCart('mat')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('mat')">Item Details</button>
            </div>
            </td>
            <td class="col3">
            <div>
                <h2 class="centered">Rotary Cutter</h2>
                <img src="cutter.png"/><br/>
                <button onclick="addToCart('rotary')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('rotary')">Item Details</button>
            </div>
            </td>
            <td class="col4">
            <div>
                <h2 class="centered">Ruler</h2>
                <img src="ruler.jpg"/><br/>
                <button onclick="addToCart('ruler')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('ruler')">Item Details</button>
            </div>
            </td>
        </tr>
        <tr>
            <td class="col1">
            <div>
                <h2 class="centered">Batting</h2>
                <img src="batting.png"/><br/>
                <button onclick="addToCart('batting')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('batting')">Item Details</button>
            </div>
            </td>
            <td class="col2">
            <div>
                <h2 class="centered">Needles</h2>
                <img src="needles.jpg"/><br/>
                <button onclick="addToCart('needles')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('needles')">Item Details</button>
            </div>
            </td>
            <td class="col3">
            <div>
                <h2 class="centered">Pins</h2>
                <img src="pins.jpg"/><br/>
                <button onclick="addToCart('pins')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('pins')">Item Details</button>
            </div>
            </td>
            <td class="col4">
            <div>
                <h2 class="centered">Sewing Machine</h2>
                <img src="machine.jpg"/><br/>
                <button onclick="addToCart('machine')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('machine')">Item Details</button>
            </div>
            </td>
        </tr>
    </table>    
    <br/><br/><br/>

    <img src="cart.png" id="cartImage"/>
    <a id="viewCartButton" href="cartPage.php">View Cart</a>

    <br/><br/>
    <div id="snackbar">This item was added to your cart</div>

  </body>
</html>