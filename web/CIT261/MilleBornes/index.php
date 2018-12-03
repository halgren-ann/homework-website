<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Mille Bornes</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="makeGame()">
    <div id="UserCard1" class="card UserCard1 overlay" onclick="clickUserCard1()"></div>
    
    <div id="drawPile" class="card drawPile overlay" onclick="clickDrawPile()"></div>
    <div id="discardPile" class="card discardPile overlay" onclick="clickDiscardPile()"></div>
    <div id="PCDrive" class="card PCDrive overlay" onclick="clickPCDrive()"></div>
    <div id="PCSpeed" class="card PCSpeed overlay" onclick="clickPCSpeed()"></div>
    <div id="PCMiles" class="card PCMiles overlay" onclick="clickPCMiles()"></div>
    <div id="UserDrive" class="card UserDrive overlay" onclick="clickUserDrive()"></div>
    <div id="UserSpeed" class="card UserSpeed overlay" onclick="clickUserSpeed()"></div>
    <div id="UserMiles" class="card UserMiles overlay" onclick="clickUserMiles()"></div>

    <div id="drawPileArea"></div>
    <button onclick="newGame()" id="newGame">New Game</button>
    <button onclick="getInstructions()" id="instructions">Instructions</button>
    <div class="card drawPile"></div>
    <div class="card discardPile"></div>

    <div id="PCPlayArea"></div>
    <p id="PCheading">PC PLAYER AREA</p>
    <div class="card PCDrive"></div>
    <div class="card PCSpeed"></div>
    <div class="card PCMiles"></div>
    <label id="PCScore">Score: -</label>

    <div id="UserPlayArea"></div>
    <p id="Userheading">USER PLAYER AREA</p>
    <div class="card UserDrive"></div>
    <div class="card UserSpeed"></div>
    <div class="card UserMiles"></div>
    <label id="UserScore">Score: -</label>

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

<footer>
    <script src="script.js"></script>
</footer>
</body>
</html>