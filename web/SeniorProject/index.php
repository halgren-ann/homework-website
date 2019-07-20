<?php   
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Mille Bornes - Group Play</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="start()" onclick="handleClick(event)">


<section id="startPlane">
    <h1 class="centered">Mille Bornes - Group Play</h1>
    <div id="welcomeBlurb">Welcome to the game Mille Bornes! To play and skype with other people, enter a name for yourself and your group's keyword below:</div>
    <br/>
    <label id="display_nameLabel">Display name:</label>
    <input id="display_name" type="text" value="">
    <br/><br/>
    <label id="keywordLabel">Keyword:</label>
    <input id="keyword" type="text" value="">
    <button id="enter" onclick="assessKeyword_part1()">Enter</button>
    <br/>
    <p id="playPCBlurb">Or, just play by yourself against the PC:</p>
    <br/>
    <button id="playPCButton" onclick="playPCGame()">Play PC</button>
</section>

<section id="waitingPlane" class="hidden">
    <h1 class="centered">Waiting Room</h1>
    <h2 id="people">People in this room:</h2>
    <div class="playerWaitArea" id="player1_wait"></div>
    <div class="playerWaitArea" id="player2_wait"></div>
    <div class="playerWaitArea" id="player3_wait"></div>
    <div class="playerWaitArea" id="player4_wait"></div>
    <p id="onlyHostCanStartBlurb">The first person here (the "Host") gets to start the game when everyone is ready.</p>
    <button id="startFromWaitingRoom" onclick="startGame()" class="hidden">Start the game with these players</button>
</section>

<section id="gamePlane" class="hidden">

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

    <div id="drawLabel">Draw</div>
    <div id="discardLabel">Discard</div>

    <div id="bottomLeftPlayerLabel" class="label">
        <div id="bottomLeftPlayerDisplay_name" class="display_name"></div>
        <div id="bottomLeftPlayerScore" class="score">Score: - </div>
    </div>
    <div id="topLeftPlayerLabel" class="label">
        <div id="topLeftPlayerDisplay_name" class="display_name"></div>
        <div id="topLeftPlayerScore" class="score">Score: - </div>
    </div>
    <div id="topRightPlayerLabel" class="label">
        <div id="topRightPlayerDisplay_name" class="display_name"></div>
        <div id="topRightPlayerScore" class="score">Score: - </div>
    </div>
    <div id="bottomRightPlayerLabel" class="label">
        <div id="bottomRightPlayerDisplay_name" class="display_name"></div>
        <div id="bottomRightPlayerScore" class="score">Score: - </div>
    </div>

    <div id="overlayPlayer3" class="hidden nonPlayerOverlay"></div>
    <div id="overlayPlayer4" class="hidden nonPlayerOverlay"></div>

    <div id="drawPile" class="card drawPile overlay" onclick="clickDrawPile()"></div>
    <div id="discardPile" class="card discardPile overlay" onclick="clickDiscardPile()"></div>
    <div id="bottomLeftPlayerDrive" class="card bottomLeftPlayerDrive overlay" onclick="clickOverlay('bottomLeftPlayerDrive')"></div>
    <div id="bottomLeftPlayerSpeed" class="card bottomLeftPlayerSpeed overlay" onclick="clickOverlay('bottomLeftPlayerSpeed')"></div>
    <div id="bottomLeftPlayerMiles" class="card bottomLeftPlayerMiles overlay" onclick="clickOverlay('bottomLeftPlayerMiles')"></div>
    <div id="topLeftPlayerDrive" class="card topLeftPlayerDrive overlay" onclick="clickOverlay('topLeftPlayerDrive')"></div>
    <div id="topLeftPlayerSpeed" class="card topLeftPlayerSpeed overlay" onclick="clickOverlay('topLeftPlayerSpeed')"></div>
    <div id="topLeftPlayerMiles" class="card topLeftPlayerMiles overlay" onclick="clickOverlay('topLeftPlayerMiles')"></div>
    <div id="topRightPlayerDrive" class="card topRightPlayerDrive overlay" onclick="clickOverlay('topRightPlayerDrive')"></div>
    <div id="topRightPlayerSpeed" class="card topRightPlayerSpeed overlay" onclick="clickOverlay('topRightPlayerSpeed')"></div>
    <div id="topRightPlayerMiles" class="card topRightPlayerMiles overlay" onclick="clickOverlay('topRightPlayerMiles')"></div>
    <div id="bottomRightPlayerDrive" class="card bottomRightPlayerDrive overlay" onclick="clickOverlay('bottomRightPlayerDrive')"></div>
    <div id="bottomRightPlayerSpeed" class="card bottomRightPlayerSpeed overlay" onclick="clickOverlay('bottomRightPlayerSpeed')"></div>
    <div id="bottomRightPlayerMiles" class="card bottomRightPlayerMiles overlay" onclick="clickOverlay('bottomRightPlayerMiles')"></div>

    <div id="sidebar">
        <iframe src="" allow-popups allow="microphone; camera" name="iframe_vid_1" id="iframe_vid_1"></iframe>
        <iframe src="" allow-popups allow="microphone; camera" name="iframe_vid_2" id="iframe_vid_2"></iframe>
        <iframe src="" allow-popups allow="microphone; camera" name="iframe_vid_3" id="iframe_vid_3"></iframe>
        <iframe src="" allow-popups allow="microphone; camera" name="iframe_vid_4" id="iframe_vid_4"></iframe>
        <div class="iframeOverlay"></div>
    </div>

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

    <img id="optionsButton" src="options.png" onclick="openOptions()">
    <div id="optionsOverlay" class="hidden">
        <img id="optionsOutline" src="optionsOutline.png" onclick="off()">
        <img id="viewInstructions" src="viewInstructions.png" onclick="openInstructions()">
        <img id="startNewGame" src="startNewGame.png" onclick="startGame()">
        <img id="changeBackgroundButton" src="changeBackgroundButton.png" onclick="changeBackgroundButton()">
        <img id="backToHomePage" src="backToHomePage.png" onclick="reload()">
        <div id="instructions"></div>
    </div>

    <div id="instructionsOverlay" class="hidden" onclick="offInstructions()">
        <div><pre id="instructionsSheet"></pre></div>
    </div>

    <div id="backgroundsOverlay" class="hidden">
        <img id="backgroundsOutline" src="backgroundsOutline.png" onclick="offBackgrounds()">
        <img id="background_1" src="background_1.jpg" onclick="setBackground(1)">
        <img id="background_2" src="background_2.jpg" onclick="setBackground(2)">
        <img id="background_3" src="background_3.jpg" onclick="setBackground(3)">
        <img id="background_4" src="background_4.jpg" onclick="setBackground(4)">
        <img id="background_5" src="background_5.jpg" onclick="setBackground(5)">
        <img id="background_6" src="panelBackground.png" onclick="setBackground(6)">
    </div>

    <!--
    <div id="endGameOverlay" style="display:none" onclick="offEndGame()">
        <div class="winslosses" id="winslosses">Wins: 0   Losses: 0</div>
        <canvas id="canvas" style="width:100%;height:100%;"></canvas>
        <p id="winbanner" class="backlitText winbanner">YOU WON!</p>
        <p id="lossbanner" class="lossbanner">YOU LOST</p>
        <button id="overlayNewGame" onclick="startGame()">New Game</button>
        <button id="overlayContinue" onclick="offEndGame()">Continue</button>
    </div>
    -->

</section>

</body>
<footer>
    <script src="script.js"></script>
</footer>
</html>