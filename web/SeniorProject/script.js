//TODO protect all inputs against malicious entry with htmlspecialchars etc.
//TODO account for the case where the person enters a keyword and tries to start a game when they are the only one in the room
//TODO is there a problem with dealing when perhaps asynchronously the start state is received before all the players are received? YES! Or moves are received before cards are dealt, too

///////////////////////////////////////////////GENERAL////////////////////////////////////////////
/*General Use AJAX*/
function AJAX(url_var, content_var, callback) {
    var httpc = new XMLHttpRequest(); // simplified for clarity
    var url = url_var;
    httpc.open("POST", url, true); // sending as POST

    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    httpc.onreadystatechange = function() { //Call a function when the state changes.
        if(httpc.readyState == 4 && httpc.status == 200) {
            callback(httpc.responseText);
        }
    }
    httpc.send(content_var);
}

//Global variables for this user
var keyword = "";
var num_players = 0;
var player_number = "";
var player_id = "";
var game_id = "";
var display_name = "";
var is_turn = false;
var score = 0;
var flag = false;

//Global variables for other players' information
var player_id1 = "";
var player_number1 = "";
var display_name1 = "";
var is_turn1 = false;
var score1 = 0;
var player_id2 = "";
var player_number2 = "";
var display_name2 = "";
var is_turn2 = false;
var score2 = 0;
var player_id3 = "";
var player_number3 = "";
var display_name3 = "";
var is_turn3 = false;
var score3 = 0;
var player_id4 = "";
var player_number4 = "";
var display_name4 = "";
var is_turn4 = false;
var score4 = 0;

//Periodic pull from the server to check for updated information
function pull() {
    var JSONstr = '{"game_id": ' + game_id + ', "player_id": ' + player_id + '}';
    AJAX("update_manager.php", JSONstr, pull_part2);
}
function pull_part2(responseText) {
    setTimeout(pull, 1000); //pull from the server every 5 seconds
    console.log(responseText);
    //TODO deal with the information returned and reflect the changes on the client
    if (responseText == "no_updates") {
        return;
    }
    else {
        //We are receiving JSON
        var updatesArray = JSON.parse(responseText);
        //TODO finish filling these in
        for (var i=0; i<updatesArray.length; i++) {
            if (updatesArray[i].desc == "new_player") {
                var temp = updatesArray[i].player_number;
                //set the corresponding global player variables
                window["player_id" + temp] = updatesArray[i].player_id;
                window["player_number" + temp] = updatesArray[i].player_number;
                window["display_name" + temp] = updatesArray[i].display_name;
                window["is_turn" + temp] = updatesArray[i].is_turn;
                window["score" + temp] = updatesArray[i].score;
                //Also, display this player in the waiting room
                var tempStr;
                if(temp == 1) {
                    tempStr = "<h1>" + window["display_name" + temp] + " (Host)</h1>";
                }
                else {
                    tempStr = "<h1>" + window["display_name" + temp] + "</h1>";
                }
                document.getElementById("player"+temp+"_wait").innerHTML = tempStr;
            }
            else if (updatesArray[i].desc == "start_state") {
                //how many players are in this game that has just been started?
                num_players = updatesArray[i].num_players;
                //update the cardArray variable with the shuffled state
                var tempArray = new Array();
                for (var j=0; j<updatesArray[i].cards.length; j++) {
                    tempArray[j] = cardArray[cardArray.findIndex(x => x.id === updatesArray[i].cards[j])];
                }
                cardArray = tempArray;
                //populate the draw pile with the updated cardArray
                for (var k=0; k<cardArray.length; k++) {
                    document.getElementById(cardArray[k].id).style = "z-index:" + (k+1);
                }
                //The game has started and we have received the start state, so hide the waiting plane and show the game plane
                document.getElementById("waitingPlane").classList.add("hidden");
                document.getElementById("gamePlane").classList.remove("hidden");

                //Now deal the cards
                deal();
            }
            else if (updatesArray[i].desc == "move") {
                debugger;
                //first, figure out which player made this move and store it in temp
                var temp = 0;
                if (player_id1 == updatesArray[i].player_id) temp = 1;
                else if (player_id2 == updatesArray[i].player_id) temp = 2;
                else if (player_id3 == updatesArray[i].player_id) temp = 3;
                else if (player_id4 == updatesArray[i].player_id) temp = 4;
                //recreate the card being played on this end
                if (updatesArray[i].start_position == "draw") {
                    document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
                    document.getElementById(cardArray[cardArray.length-1].id).zIndex = 7;
                    window["HandArray" + temp].push(cardArray[cardArray.length-1]);
                    document.getElementById(cardArray[cardArray.length-1].id).classList.add(convertToCSSClass("HandArray"+temp));
                    cardArray.pop();
                    if(cardArray.length == 0) {
                        reshuffle();
                    }
                }
                else if (updatesArray[i].start_position == "discard") {
                    document.getElementById(discardPileArray[discardPileArray.length-1].id).classList.remove("discardPile");
                    document.getElementById(discardPileArray[discardPileArray.length-1].id).childNodes[1].classList.toggle("flip");
                    document.getElementById(discardPileArray[discardPileArray.length-1].id).zIndex = 7;
                    window["HandArray" + temp].push(discardPileArray[discardPileArray.length-1]);
                    document.getElementById(discardPileArray[discardPileArray.length-1].id).classList.add(convertToCSSClass("HandArray"+temp));
                    discardPileArray.pop();
                }
                else {
                    playCard(temp, updatesArray[i].start_position, document.getElementById(updatesArray[i].card_id), window["HandArray" + temp][updatesArray[i].start_position - 1], convertToCSSClass(updatesArray[i].end_position));
                }
            }
            else {
                //TODO error or no updates
            }
        }
    }
}

///////////////////////////////////END GENERAL////////////////////////////////////////



///////////////////////////////////GAME PLANE///////////////////////////////////////
//Arrays to hold card stacks
var cardArray; //cardArray is the draw deck
cardArray = makeArray();
var discardPileArray = new Array(); //this is the array for the discard pile
var DriveArray = new Array();
var SpeedArray = new Array();
var MilesArray = new Array();
var HandArray = new Array();

var DriveArray1 = new Array();
var SpeedArray1 = new Array();
var MilesArray1 = new Array();
var HandArray1 = new Array();

var DriveArray2 = new Array();
var SpeedArray2 = new Array();
var MilesArray2 = new Array();
var HandArray2 = new Array();

var DriveArray3 = new Array();
var SpeedArray3 = new Array();
var MilesArray3 = new Array();
var HandArray3 = new Array();

var DriveArray4 = new Array();
var SpeedArray4 = new Array();
var MilesArray4 = new Array();
var HandArray4 = new Array();

//items relevant to game play logic
var haveDrawn = false;
var selectedCard = null;
var afterGame = false;
var validArray = new Array();

function startGame() {
    //generate the random card stack
    cardArray = shuffleArray(cardArray);

    var JSONstr = '{"game_id": "' + game_id + '", "cardArray": ' + JSON.stringify(cardArray) + '}';
    //Send this deck information to the server
    AJAX("makeGame.php", JSONstr, dummy);
    //Put the display names in
    displayNames();
}

function dummy(responseText) {
    //Do nothing
    console.log(responseText);
}

function displayNames() {
    for (var i=0; i<num_players; i++) {
        if (i==0) {
            document.getElementById("bottomLeftPlayerDisplay_name").innerHTML = "     " + display_name;
        }
        else if (i==1) {
            document.getElementById("topLeftPlayerDisplay_name").innerHTML = "     " + window["display_name" + roll("")];
        }
        else if (i==2) {
            document.getElementById("topRightPlayerDisplay_name").innerHTML = "     " + window["display_name" + roll(roll(""))];
        }
        else if (i==3) {
            document.getElementById("bottomRightPlayerDisplay_name").innerHTML = "     " + window["display_name" + roll(roll(roll("")))];
        }
    }
}

function deal() {
    displayNames();
    console.log("Game is started....dealing the cards");
    //debugger;
    for (var i=1; i<=6; i++) {
        //deal the ith card to each player
        for (var j=1; j<=num_players; j++) {
            var tempPlayerNum; 
            //Always deal to player number 1 first
            if (player_number == j){
                tempPlayerNum = "";
            }
            else {
                tempPlayerNum = j;
            }
            document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
            document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = i;
            if (tempPlayerNum == "") {
                //We're currently dealing to this user
                document.getElementById(cardArray[cardArray.length-1].id).childNodes[1].classList.toggle("flip");
                document.getElementById(cardArray[cardArray.length-1].id).classList.add("playerHand" + i);
            }
            else {
                document.getElementById(cardArray[cardArray.length-1].id).classList.add(convertToCSSClass("HandArray" + tempPlayerNum));
            }
            window["HandArray" + tempPlayerNum].push(cardArray[cardArray.length-1]);
            cardArray.pop();
        }
    }
}

/*This function returns the number of the next player, depending on how many people are playing. For example, if 3
people are playing, then an input of 1 would give output of 2, input of 2 would output 3, and input of 3 would output
1. Also, if the number to be output is the number of this user, an empty string is returned instead of the number to
facilitate variable names. If the input is an empty string, then the number of the next player after the current player is returned.*/
function roll(num) {
    //add one to the input
    if (num.length == 0) {
        num = parseInt(player_number) + parseInt(1);
    }
    else {
        num = parseInt(num) + parseInt(1);
    }
    //roll
    if (num > num_players) {
        num = 1;
    }
    //return
    if (num == player_number) {
        return "";
    }
    else {
        return num;
    }

}

/*This function takes the name of a card stack array and, based on the number of players, the current user's player number, and the input,
returns the name of the CSS class that the array is visually positioned with.*/
//TODO wherever this is returned, account for if the array is this user's hand, which applies to several CSS classes instead of just one 
function convertToCSSClass(arrayName) {
    if (arrayName == "discardPileArray") return "discardPile";
    //the draw deck and discard pile are always in the same place, so the meaningful inputs are the DriveArray, SpeedArray, MilesArray, and HandArray variables
    var answerStr = "";
    //first, figure out the top, bottom, right, left player position on this user's screen
    var last = arrayName[arrayName.length-1];
    if (last == "y" || last == player_number || last == "e") {
        //this array belongs to the current player
        answerStr += "bottomLeftPlayer";
    }
    else {
        //find out how far offset the player is from this user
        var counter = 1;
        var rollOnThis = "";
        for (var i=0; i<num_players; i++) {
            if (roll(rollOnThis) == last) {
                break;
            }
            counter++;
            rollOnThis = roll(rollOnThis);
        }

        if (counter == 1) {
            answerStr += "topLeftPlayer";
        }
        else if (counter == 2) {
            answerStr += "topRightPlayer";
        }
        else if (counter == 3) {
            answerStr += "bottomRightPlayer";
        }
    }
    //now, get which position within that play area
    var first = arrayName.substring(0, 2);
    if (first == "Dr") {
        answerStr += "Drive";
    }
    else if (first == "Sp") {
        answerStr += "Speed";
    }
    else if (first == "Sc") {
        answerStr += "Score";
    }
    else if (first == "Mi") {
        answerStr += "Miles";
    }
    else if (first == "Ha") {
        answerStr += "Hand";
    }
    //finally, return the CSS class name
    return answerStr;
}

//This function is the reverse of convertToCSSClass
function convertCSSClassToArray(CSSClass) {
    var begin = CSSClass.substring(0, CSSClass.length-5);
    var end =  CSSClass.substring(CSSClass.length-5, CSSClass.length);
    var result = "";

    if (end == "Drive") {
        result += "Drive";
    }
    else if (end == "Speed") {
        result += "Speed";
    }
    else if (end == "Miles") {
        result += "Miles";
    }

    if (num_players == 2) {
        if (begin == "bottomLeftPlayer") {
            result += "Array";
        }
        else if (begin == "topLeftPlayer") {
            result += "Array" + roll(player_number);
        }
    }
    else if (num_players == 3) {
        if (begin == "bottomLeftPlayer") {
            result += "Array";
        }
        else if (begin == "topLeftPlayer") {
            result += "Array" + roll(player_number);
        }
        else if (begin == "topRightPlayer") {
            result += "Array" + roll(roll(player_number));
        }
    }
    else if (num_players == 4) {
        if (begin == "bottomLeftPlayer") {
            result += "Array";
        }
        else if (begin == "topLeftPlayer") {
            result += "Array" + roll(player_number);
        }
        else if (begin == "topRightPlayer") {
            result += "Array" + roll(roll(player_number));
        }
        else if (begin == "bottomRightPlayer") {
            result += "Array" + roll(roll(roll(player_number)));
        }
    }

    return result;
}

//Make the card object
//Valid values are as follows:
//name: 25, 50, 75, 100, 200, Drive, Stop, Gas, OutOfFuel, SpareTire, FlatTire, EndSpeedLimit, SpeedLimit, Repairs, Accident
//type: attack, remedy, mile
function card(idNum, name, type) {
    this.id = "_" + idNum;
    this.name = name;
    this.type = type;
}

function makeArray() {
    var cardArray = new Array();
    var j=1;
    for (var i=0; i<10; i++) {
        newCard = new card(j, "25", "mile");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<10; i++) {
        newCard = new card(j, "50", "mile");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<10; i++) {
        newCard = new card(j, "75", "mile");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<12; i++) {
        newCard = new card(j, "100", "mile");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<4; i++) {
        newCard = new card(j, "200", "mile");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<14; i++) {
        newCard = new card(j, "Drive", "remedy");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<5; i++) {
        newCard = new card(j, "Stop", "attack");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<6; i++) {
        newCard = new card(j, "Gas", "remedy");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<3; i++) {
        newCard = new card(j, "OutOfFuel", "attack");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<6; i++) {
        newCard = new card(j, "SpareTire", "remedy");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<3; i++) {
        newCard = new card(j, "FlatTire", "attack");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<6; i++) {
        newCard = new card(j, "EndSpeedLimit", "remedy");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<4; i++) {
        newCard = new card(j, "SpeedLimit", "attack");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<6; i++) {
        newCard = new card(j, "Repairs", "remedy");
        cardArray.push(newCard);
        j++;
    }
    for (var i=0; i<3; i++) {
        newCard = new card(j, "Accident", "attack");
        cardArray.push(newCard);
        j++;
    }

    return cardArray;
}

/**
 * Randomize array element order in-place.
 * Using Durstenfeld shuffle algorithm.
 */
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }

    return array;
}

//Add a click event listener to handle clicking the user cards from their hand
function handleClick(e) {    
    e.preventDefault();
    if (haveDrawn) {
        if(!e.target.parentElement || !e.target.parentElement.parentElement || !e.target.parentElement.parentElement.parentElement) return;
        if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand1")) selectCard(1);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand2")) selectCard(2);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand3")) selectCard(3);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand4")) selectCard(4);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand5")) selectCard(5);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand6")) selectCard(6);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("playerHand7")) selectCard(7);
    }
}

function selectCard(cardNum) {
    //Select this card
    selectedCard = HandArray[cardNum-1];
    //unhighlight anything that is still highlighted
    unhighlightValidMoves();
    //Clear out valid array
    validArray = [];
    //check for all valid options
    findValidMoves();
    //highlight valid options
    highlightValidMoves();
}

function findValidMoves() {
    if (selectedCard.name == "SpeedLimit") {
        var temp = "";
        while(roll(temp) != "") {
            temp = roll(temp);            
            if (!window["SpeedArray" + temp][0] || window["SpeedArray" + temp][window["SpeedArray" + temp].length-1].name == "EndSpeedLimit") {
                validArray.push(convertToCSSClass("SpeedArray" + temp));
            }
        }
    }
    else if (selectedCard.type == "attack") {
        var temp = "";
        while(roll(temp) != "") {
            temp = roll(temp);            
            if (window["DriveArray" + temp][0] && window["DriveArray" + temp][window["DriveArray" + temp].length-1].type == "remedy") {
                validArray.push(convertToCSSClass("DriveArray" + temp));
            }
        }
    }
    else if (selectedCard.name == "EndSpeedLimit") {
        if (SpeedArray[0] && SpeedArray[SpeedArray.length-1].name == "SpeedLimit") {
            validArray.push(convertToCSSClass("SpeedArray"));
        }
    }
    else if (selectedCard.type == "remedy") {
        if (selectedCard.name == "Drive") {
            //can play if either the User drive pile is empty or has a stop on it
            if (!DriveArray[0] || DriveArray[DriveArray.length-1].name == "Stop") {
                validArray.push(convertToCSSClass("DriveArray"));
            }
        }
        else if (selectedCard.name == "Repairs") {
            if (DriveArray[0] && DriveArray[DriveArray.length-1].name == "Accident") {
                validArray.push(convertToCSSClass("DriveArray"));
            }
        }
        else if (selectedCard.name == "SpareTire") {
            if (DriveArray[0] && DriveArray[DriveArray.length-1].name == "FlatTire") {
                validArray.push(convertToCSSClass("DriveArray"));
            }
        }
        else if (selectedCard.name == "Gas") {
            if (DriveArray[0] && DriveArray[DriveArray.length-1].name == "OutOfFuel") {
                validArray.push(convertToCSSClass("DriveArray"));
            }
        }
    }
    else if (selectedCard.type == "mile") {
        //there must be a drive card down first and there cannot be an attack card on the user
        if (DriveArray[0] && DriveArray[DriveArray.length-1].type == "remedy") {
            //check to make sure it's 50 or less if there is a speed limit on the user
            if (SpeedArray[0] && SpeedArray[SpeedArray.length-1].type == "attack") {
                if (Number(selectedCard.name) <= 50) {
                    validArray.push(convertToCSSClass("MilesArray"));
                }
            }
            else {
                validArray.push(convertToCSSClass("MilesArray"));
            }
        }
    }

    //The discard pile is always valid
    validArray.push("discardPile");
    console.log("Valid array: ");
    for (var i=0; i<validArray.length; i++) {
        console.log(validArray[i]);
    }
}

function highlightValidMoves() {
    //first, select the currently selected card
    //document.getElementById(selectedCard.id).classList.add("backlit");
    document.getElementById(selectedCard.id).classList.add("hoverSim");
    //Then highlight the possible options
    for (var i=0; i<validArray.length; i++) {
        document.getElementsByClassName(validArray[i])[0].classList.add("backlit");
    }
}

function unhighlightValidMoves() {
    if(document.getElementsByClassName("hoverSim")[0]) {
        document.getElementsByClassName("hoverSim")[0].classList.remove("hoverSim");
    }
    //Unhighlight the possible options
    for (var i=0; i<validArray.length; i++) {
        document.getElementsByClassName(validArray[i])[0].classList.remove("backlit");
    }
}

//TODO use this function
function prepUserTurn() {
    //highlight the draw pile
    document.getElementsByClassName("discardPile")[0].classList.add("backlit");
    document.getElementsByClassName("drawPile")[0].classList.add("backlit");
}

function setFlag() {
    flag = true;
}

function waitForFlag(phpFile, info, callback) {
    if (flag) {
        flag = false;
        AJAX(phpFile, info, callback);
    }
    else {
        setTimeout(waitForFlag, 2000, phpFile, info, callback);
    }
}

function clickDrawPile() {
    if (is_turn && !haveDrawn) {
        //draw a card
        //debugger;
        document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
        document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = 7;
        document.getElementById(cardArray[cardArray.length-1].id).childNodes[1].classList.toggle("flip");
        document.getElementById(cardArray[cardArray.length-1].id).classList.add("playerHand7");
        HandArray.push(cardArray[cardArray.length-1]);
        cardArray.pop();
        haveDrawn = true;
        document.getElementsByClassName("discardPile")[0].classList.remove("backlit");
        document.getElementsByClassName("drawPile")[0].classList.remove("backlit");
        setTimeout(selectCard, 300, 7);
        //Tell the database that I made this move
        var start_position = "draw";
        var JSONstr = '{"game_id": "' + game_id + '", "player_id": "' + player_id + '", "card_id": "' + HandArray[HandArray.length-1].id + '", "start_position": "' + start_position + '", "end_position": ' + '"HandArray' + player_number + '"}';
        AJAX("moves.php", JSONstr, setFlag);
    }
}

function clickDiscardPile() {
    //check for the scenario where the user is trying to draw from the DiscardPile
    if (is_turn && !haveDrawn && discardPileArray[0]) {
        //draw a card
        //debugger;
        document.getElementById(discardPileArray[discardPileArray.length-1].id).classList.remove("discardPile");
        document.getElementById(discardPileArray[discardPileArray.length-1].id).style.zIndex = 7;
        document.getElementById(discardPileArray[discardPileArray.length-1].id).classList.add("playerHand7");
        HandArray.push(discardPileArray[discardPileArray.length-1]);
        discardPileArray.pop();
        haveDrawn = true;
        document.getElementsByClassName("discardPile")[0].classList.remove("backlit");
        document.getElementsByClassName("drawPile")[0].classList.remove("backlit");
        setTimeout(selectCard, 300, 7);
        //Tell the database that I made this move
        var start_position = "discard";
        var JSONstr = '{"game_id": "' + game_id + '", "player_id": "' + player_id + '", "card_id": "' + HandArray[HandArray.length-1].id + '", "start_position": "' + start_position + '", "end_position": ' + '"HandArray' + player_number + '"}';
        AJAX("moves.php", JSONstr, setFlag);
    }
    else if (is_turn && haveDrawn && selectedCard != null) {
        debugger;
        //tell the database that I made this move
        var start_position = parseInt(HandArray.indexOf(selectedCard)+1);
        var JSONstr = '{"game_id": "' + game_id + '", "player_id": "' + player_id + '", "card_id": "' + selectedCard.id + '", "start_position": "' + start_position + '", "end_position": ' + '"discardPileArray"}';
        //AJAX("moves.php", JSONstr, dummy);
        //I can only make this move once the database knows I've drawn
        waitForFlag("moves.php", JSONstr, dummy);

        //The user is discarding
        playCard("", HandArray.indexOf(selectedCard)+1, document.getElementById(selectedCard.id), selectedCard, "discardPile");
        //clear out and reset
        selectedCard = null;
        unhighlightValidMoves();
        haveDrawn = false;
        validArray = [];
        is_turn = false;
        if(cardArray.length == 0) {
            reshuffle();
        }
    }
}

function clickOverlay(location) {
    if (validArray[0] && validArray.includes(location)) {
        debugger;
        //stop highlighting items
        unhighlightValidMoves();
        //tell the database that I made this move
        var end_position = convertCSSClassToArray(location);
        if(end_position[end_position.length-1] == "y") {
            end_position = end_position + player_number;
        }
        var start_position = parseInt(HandArray.indexOf(selectedCard)+1);
        var JSONstr = '{"game_id": "' + game_id + '", "player_id": "' + player_id + '", "card_id": "' + selectedCard.id + '", "start_position": "' + start_position + '", "end_position": "' + end_position + '"}';
        //AJAX("moves.php", JSONstr, dummy);
        waitForFlag("moves.php", JSONstr, dummy);
        //move the card to take the turn
        playCard("", HandArray.indexOf(selectedCard)+1, document.getElementById(selectedCard.id), selectedCard, location);
        //clear selectedCard
        selectedCard = null;
        //clear out validArray
        validArray = [];
        //clear haveDrawn
        haveDrawn = false;
        //stop the user's turn
        is_turn = false;
        if(cardArray.length == 0) {
            reshuffle();
        }
    }
}

function playCard(who, cardNumInHand, cardElement, card, whereTo) {
    debugger;
    //remove the current class
    if (who == "") {
        cardElement.classList.remove("playerHand"+cardNumInHand);
    }
    else {
        cardElement.classList.remove(convertToCSSClass("HandArray"+who));
    }
    //arrange the new z-index and add the new array
    if (whereTo == "discardPile") {
        if (!discardPileArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = discardPileArray.length + 1;
        discardPileArray.push(card);
    }
    else {
        if(!window[convertCSSClassToArray(whereTo)][0]) {
            cardElement.style.zIndex = 1;
        }
        else {
            cardElement.style.zIndex = window[convertCSSClassToArray(whereTo)].length + 1;
        }
        window[convertCSSClassToArray(whereTo)].push(card);
    }
    //add the new class
    cardElement.classList.add(whereTo);
    //flip the card if it's coming from any other hand than the current user's
    if (who != "") {
        cardElement.childNodes[1].classList.toggle("flip");
    }
    //remove the card from its respective hand array
    window["HandArray" + who].splice(cardNumInHand-1,1);
    //shift the cards in the hand that remain
    shiftCards(who, cardNumInHand);
    //Update the score if this is a miles card
    if (convertCSSClassToArray(whereTo).substring(0, 5) == "Miles") {
        updateScore(who);
    }
    //rotate the turn
    for (var i=1; i<=num_players; i++) {
        var num = i;
        if (player_number == num) {
            num = "";
        }
        if (roll(who) == num) {
            window["is_turn" + num] = true;
        }
        else {
            window["is_turn" + num] = false;
        }
    }
    //if it is this user's turn now, notify them and highlight the draw and discard piles
    if (is_turn) {
        //TODO alert the current user that it is now their turn
        setTimeout(prepUserTurn, 1000);
    }
    //reshuffle the discard pile into the draw pile if the draw pile is empty
    if(cardArray.length == 0) {
        reshuffle();
    }
}

function shiftCards(who, cardNumInHand) {
    for (var i=cardNumInHand+1; i<=7; i++) {
        if (who == "") {
            var cardElement = document.getElementsByClassName("playerHand"+i)[0];
            cardElement.classList.remove("playerHand"+i);
            var cardNumMinus1 = i-1;
            cardElement.classList.add("playerHand"+cardNumMinus1);
            cardElement.style.zIndex = cardNumMinus1;
        }
        else {
            var cardElement = document.getElementsByClassName(convertToCSSClass("HandArray" + who))[0];
            var cardNumMinus1 = i-1;
            cardElement.style.zIndex = cardNumMinus1;
        }
    }
}

function updateScore(who) {
    var total = 0;
    for (var i=0; i < window["MilesArray" + who].length; i++) {
        total += Number(window["MilesArray" + who][i].name);
    }
    document.getElementById(convertToCSSClass("Score" + who)).innerHTML = "Score: " + total;
    if (!afterGame && total >= 1000) endGame(who);
}

function endGame(winner) {
    afterGame = true;
    alert(window["display_name" + winner] + " has won the game!");
    //TODO maybe make the game obsolete in the database at this point??
    
    /*
    document.getElementById("endGameOverlay").style.display = "block";
    if(winner == "User") {
        document.getElementById("winbanner").classList.add("winner");
        animate();
        //tally the wins and losses
        localStorage["wins"] = Number(localStorage["wins"]) + 1;
    }
    else {
        document.getElementById("lossbanner").classList.add("winner");
        localStorage["losses"] = Number(localStorage["losses"]) + 1;
    }
    document.getElementById("winslosses").innerHTML = "Wins: " + localStorage["wins"] + "      Losses: " + localStorage["losses"];
    */
}

///////////////////////////////////////////END GAME PLANE///////////////////////////////







/////////////////////////////////////////START PLANE/////////////////////////////////////
/*
This function gathers the input keyword. If the keyword is found in the databse:
    - The player is assigned a number (2-4) and added to that game instance
If the keyword is not found in the database:
    - A new instance of the game is created and this player is made the game host
*/
function assessKeyword_part1() {
    //TODO make sure the case where a keyword or diplay name was not entered is accounted for
    keyword = (document.getElementById("keyword").value).toLowerCase();
    display_name = document.getElementById("display_name").value;
    var JSONstr = '{"keyword":"' + keyword + '", "display_name": "' + display_name + '"}';
    AJAX("assessKeyword.php", JSONstr, assessKeyword_part2);
}

/* the response will be JSON in the form
{
"player_id": "x",
"player_number": "y",
"game_id": "z"
}
*/
//the response will be a number 1-4 representing this player's player_number (1 means the player is the host).
//If there were already 4 players when the request was made, the response will be "error" for both items
function assessKeyword_part2(responseText) {
    responseText = JSON.parse(responseText);
    if (responseText.player_number == "error") {
        //TODO there are already four players with this keyword. Keep the other info they entered, but prompt for another keyword
    }
    else {
        player_number = responseText.player_number;
        player_id = responseText.player_id;
        game_id = responseText.game_id;
        //TODO display success toast
        document.getElementById("startPlane").classList.add("hidden");
        document.getElementById("waitingPlane").classList.remove("hidden");
        console.log("Player number: " + player_number);
        console.log("Player_id: " + player_id);
        console.log("Game_id: " + game_id);
        //Display this user in the waiting room
        var tempStr;
        if(player_number == 1) {
            tempStr = "<h1>" + display_name + " (Host)</h1>";
            //This person is the host, so display the start button so they can start the game when ready
            document.getElementById("startFromWaitingRoom").classList.remove("hidden");
            //It is also this person's turn, because the host always starts
            is_turn = true;
        }
        else {
            tempStr = "<h1>" + display_name + "</h1>";
        }
        document.getElementById("player"+player_number+"_wait").innerHTML = tempStr;
    }
    
}

//TODO: create function playPCGame that begins a game between the user and the PC
function playPCGame() {

}

//////////////////////////////////////END START PLANE///////////////////////////////////









//////////////////////////////////////////WAITING PLANE////////////////////////////////

////////////////////////////////////END WAITING PLANE//////////////////////////////////