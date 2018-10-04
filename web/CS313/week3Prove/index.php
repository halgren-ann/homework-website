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
            <td>
                <img src="fabric.jpg"/>
                <br/>
                <button onclick="addToCart('fabric')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('fabric')">Item Details</button>
            </td>
        </tr>
    </table>

  </body>
</html>