<?php

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
            <td id="col1">
                <img src="fabric.jpg"/>
                <br/>
                <button onclick="addToCart('fabric')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('fabric')">Item Details</button>
            </td>
            <td id="col2">
                <img src="mat.jpg"/>
                <br/>
                <button onclick="addToCart('mat')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('mat')">Item Details</button>
            </td>
            <td id="col3">
                <img src="cutter.png"/>
                <br/>
                <button onclick="addToCart('rotary')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('rotary')">Item Details</button>
            </td>
            <td id="col4">
                <img src="ruler.jpg"/>
                <br/>
                <button onclick="addToCart('ruler')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('ruler')">Item Details</button>
            </td>
        </tr>
    </table>
    


  </body>
</html>