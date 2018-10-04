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
    <!--
    <table>
        <tr>
            <td>
                <img src="fabric.jpg"/>
                <br/>
                <button onclick="addToCart('fabric')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('fabric')">Item Details</button>
            </td>
            <td>
                <img src="mat.jpg"/>
                <br/>
                <button onclick="addToCart('mat')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('mat')">Item Details</button>
            </td>
            <td>
                <img src="cutter.png"/>
                <br/>
                <button onclick="addToCart('rotary')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('rotary')">Item Details</button>
            </td>
            <td>
                <img src="ruler.jpg"/>
                <br/>
                <button onclick="addToCart('ruler')">Add to Cart</button>
                <br/>
                <button onclick="getDetails('ruler')">Item Details</button>
            </td>
        </tr>
    </table>
    -->

    <!-- Products with Checkboxes -->
    <!-- Row 1 -->
    <form action="" id="fullForm" method="post">
        <div>
            <p>Fabric</p>
            <input type="checkbox" name="fabricCheck" id="fabricCheck" onchange="updateTotals()" />
            <img src="fabric.jpg" alt="fabric" width="200" />
        </div>



        <div>
            <p>Ruler</p>
            <input type="checkbox" name="rulerCheck" id="rulerCheck" onchange="updateTotals()" />
            <img src="ruler.jpg" alt="ruler" width="200" />
        </div>



        <div>
            <p>Mat</p>
            <input type="checkbox" name="matCheck" id="matCheck" onchange="updateTotals()" />
            <img src="mat.jpg" alt="mat" width="200" />
        </div>


        <br /><br />

        <!-- Row 2 -->

        <div>
            <p>Rotary Cutter</p>
            <input type="checkbox" name="cutterCheck" id="cutterCheck" onchange="updateTotals()" />
            <img src="cutter.png" alt="cutter" width="200" />
        </div>



        <div>
            <p>Pins</p>
            <input type="checkbox" name="pinsCheck" id="pinsCheck" onchange="updateTotals()" />
            <img src="pins.jpg" alt="pins" width="200" />
        </div>



        <div>
            <p>Safety Pins</p>
            <input type="checkbox" name="safety_pinsCheck" id="safety_pinsCheck" onchange="updateTotals()" />
            <img src="safety_pins.jpg" alt="saftety pins" width="200" />
        </div>


        <br /><br />

        <!-- Row 3 -->

        <div>
            <p>Needles</p>
            <input type="checkbox" name="needlesCheck" id="needlesCheck" onchange="updateTotals()" />
            <img src="needles.jpg" alt="needles" width="200" />
        </div>



        <div>
            <p>Sewing Machine</p>
            <input type="checkbox" name="machineCheck" id="machineCheck" onchange="updateTotals()" />
            <img src="machine.jpg" alt="sewing machine" width="200" />
        </div>



        <div>
            <p>Batting</p>
            <input type="checkbox" name="battingCheck" id="battingCheck" onchange="updateTotals()" />
            <img src="batting.png" alt="batting" width="200" />
        </div>


        <br /><br /><br />


  </body>
</html>