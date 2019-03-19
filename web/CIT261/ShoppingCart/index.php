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
    <br/><br/><br/>
    <table>
        <tr>
            <td class="col1">
                <h2>Fabric</h2>
                <img src="fabric.jpg"/>
                <button onclick="addToCart('fabric')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('fabric')">Item Details</button>
            </td>
            <td class="col2">
                <h2>Cutting Mat</h2>
                <img src="mat.jpg"/>
                <button onclick="addToCart('mat')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('mat')">Item Details</button>
            </td>
            <td class="col3">
                <h2>Rotary Cutter</h2>
                <img src="cutter.png"/>
                <button onclick="addToCart('rotary')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('rotary')">Item Details</button>
            </td>
            <td class="col4">
                <h2>Ruler</h2>
                <img src="ruler.jpg"/>
                <button onclick="addToCart('ruler')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('ruler')">Item Details</button>
            </td>
        </tr>
        <tr>
            <td class="col1">
                <h2>Batting</h2>
                <img src="batting.png"/>
                <button onclick="addToCart('batting')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('batting')">Item Details</button>
            </td>
            <td class="col2">
                <h2>Needles</h2>
                <img src="needles.jpg"/>
                <button onclick="addToCart('needles')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('needles')">Item Details</button>
            </td>
            <td class="col3">
                <h2>Pins</h2>
                <img src="pins.jpg"/>
                <button onclick="addToCart('pins')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('pins')">Item Details</button>
            </td>
            <td class="col4">
                <h2>Sewing Machine</h2>
                <img src="machine.jpg"/>
                <button onclick="addToCart('machine')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('machine')">Item Details</button>
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