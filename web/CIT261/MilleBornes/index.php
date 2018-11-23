<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Mille Bornes</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="newGame()">
    <div id="drawPileArea"></div>
    <button onclick="newGame()" id="newGame">New Game</button>
    <button onclick="getInstructions()" id="instructions">Instructions</button>
    <div class="card drawPile"></div>
    <div class="card discardPile"></div>

    <div id="PCPlayArea"></div>
    <p id="PCheading">PC PLAYER AREA</p>
    <div class="card PCCard1"></div>
    <div class="card PCCard2"></div>
    <div class="card PCCard3"></div>
    <div class="card PCCard4"></div>
    <div class="card PCCard5"></div>
    <div class="card PCCard6"></div>
    <div class="card PCCard7"></div>
    <div class="card PCDrive"></div>
    <div class="card PCSpeed"></div>
    <div class="card PCMiles"></div>
    <label id="PCScore">Score: -</label>

    <div id="UserPlayArea"></div>
    <p id="Userheading">USER PLAYER AREA</p>
    <div class="card UserCard1"></div>
    <div class="card UserCard2"></div>
    <div class="card UserCard3"></div>
    <div class="card UserCard4"></div>
    <div class="card UserCard5"></div>
    <div class="card UserCard6"></div>
    <div class="card UserCard7"></div>
    <div class="card UserDrive"></div>
    <div class="card UserSpeed"></div>
    <div class="card UserMiles"></div>
    <label id="UserScore">Score: -</label>

    <?php
        for ($i=1; $i <= 10; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front card">
                        <img src="25.png">
                    </div>
                    <div class="flip-card-back  card">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=11; $i <= 20; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front card">
                        <img src="50.png">
                    </div>
                    <div class="flip-card-back card">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=21; $i <= 30; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front card">
                        <img src="75.png">
                    </div>
                    <div class="flip-card-back card">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=31; $i <= 42; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front card">
                        <img src="100.png">
                    </div>
                    <div class="flip-card-back card">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=43; $i <= 46; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front card">
                        <img src="200.png">
                    </div>
                    <div class="flip-card-back card">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }

        for ($i=47; $i <= 60; $i++) {
            echo '
            <div id="_' . $i . '" class="flip-card drawPile">
                <div class="flip-card-inner">
                    <div class="flip-card-front card">
                        <img src="drive.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="stop.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="gas.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="outOfGas.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="spareTire.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="flatTire.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="endSpeedLimit.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="speedLimit.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="repairs.png">
                    </div>
                    <div class="flip-card-back card">
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
                    <div class="flip-card-front card">
                        <img src="accident.png">
                    </div>
                    <div class="flip-card-back card">
                        <img src="cardBack.png">
                    </div>
                </div>
            </div>
            ';
        }
    ?>

<footer>
    <script src="script.js"></script>
</footer>
</body>
</html>