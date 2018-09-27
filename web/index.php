<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Homework Website</title>
    <link rel="stylesheet" type="text/css" href="styles.css">    
</head>
<body>
    <div id="header" class="black">
        <hr />
        <a href="">Ann Halgren</a>
        <hr />
    </div>
    <div id="sidebar" class="black">
        <div class="sideElement">
            <a id="about" href="About/about.html">About Me</a>
        </div>
        <hr />
        <div class="sideElement">
            <button onclick="revealClasses()" id="seeClasses" class="black">See Classes</button>
        </div>
        <hr />
        <!--Initially hidden with CSS-->
        <div id="classList" class="black">
            <hr />
            <a href = "/CS313/cs313.html" >CS 313</a >
            <hr />
            <p>CS 261</p>
            <hr />
            <p>CS 364</p>
            <hr />
            <p>FDREL 250</p>
            <hr />
        </div>
		<div id="date">
			<?php
				date_default_timezone_set("America/New_York");
				echo "Today is " . date("l, m-d-Y");
				echo "<br>";
				echo $_SERVER['SERVER_NAME'];
			?>
		</div>
    </div>
    <div id="picture" class="black">
        <img id="handsPic" src="hands.jpg" alt="Hands" />
    </div>

    <script>
        function revealClasses() {
            document.getElementById("classList").style.visibility = "visible";
        }
    </script>

</body>
</html>
