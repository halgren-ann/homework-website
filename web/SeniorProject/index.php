<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Mille Bornes - Group Play</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="makeGame()" onclick="handleClick(event)">

<div id="nonSidebar"></div>

<div class="topLeftPlayerDrive cardOutline"></div>
<div class="topLeftPlayerSpeed cardOutline"></div>
<div class="topLeftPlayerMiles cardOutline"></div>

<div class="topRightPlayerDrive cardOutline"></div>
<div class="topRightPlayerSpeed cardOutline"></div>
<div class="topRightPlayerMiles cardOutline"></div>

<div class="bottomLeftPlayerDrive cardOutline"></div>
<div class="bottomLeftPlayerSpeed cardOutline"></div>
<div class="bottomLeftPlayerMiles cardOutline"></div>

<div class="bottomRightPlayerDrive cardOutline"></div>
<div class="bottomRightPlayerSpeed cardOutline"></div>
<div class="bottomRightPlayerMiles cardOutline"></div>

<div class="drawPile cardOutline"></div>
<div class="discardPile cardOutline"></div>

<?php
        for ($i=1; $i <= 10; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="25.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=11; $i <= 20; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card  card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="50.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=21; $i <= 30; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="75.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=31; $i <= 42; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="100.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=43; $i <= 46; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="200.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=47; $i <= 60; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="drive.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=61; $i <= 65; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="stop.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=66; $i <= 71; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="gas.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=72; $i <= 74; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="outOfGas.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=75; $i <= 80; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="spareTire.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=81; $i <= 83; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="flatTire.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=84; $i <= 89; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="endSpeedLimit.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=90; $i <= 93; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="speedLimit.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=94; $i <= 99; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="repairs.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=100; $i <= 102; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="accident.png">
                    </div>
                    <div class="flip-card-back">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }
    ?>

<div id="sidebar">
    <iframe src="https://appr.tc/r/wow_1" allow-popups allow="microphone; camera" name="iframe_vid_1"></iframe>
    <iframe src="https://appr.tc/r/wow_2" allow-popups allow="microphone; camera" name="iframe_vid_2"></iframe>
    <iframe src="https://appr.tc/r/wow_3" allow-popups allow="microphone; camera" name="iframe_vid_3"></iframe>
    <iframe src="https://appr.tc/r/wow_4" allow-popups allow="microphone; camera" name="iframe_vid_4"></iframe>
</div>
</body>
<footer>
    <script src="script.js"></script>
</footer>
</html>