//TODO protect all inputs against malicious entry with htmlspecialchars etc.
//TODO account for the case where the person enters a keyword and tries to start a game when they are the only one in the room

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
    setTimeout(pull, 5000); //pull from the server every 5 seconds
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

            }
            else {
                //TODO error
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
}

function dummy() {
    //Do nothing
}

function deal() {
    console.log("Game is started....dealing the cards");
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
        num = num + 1;
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
    //the draw deck and discard pile are always in the same place, so the meaningful inputs are the DriveArray, SpeedArray, MilesArray, and HandArray variables
    var answerStr = "";
    //first, figure out the top, bottom, right, left player position on this user's screen
    var last = arrayName[arrayName.length-1];
    if (last == "y") {
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
    var first = arrayName[0];
    if (first == "D") {
        answerStr += "Drive";
    }
    else if (first == "S") {
        answerStr += "Speed";
    }
    else if (first == "M") {
        answerStr += "Miles";
    }
    else if (first == "H") {
        answerStr += "Hand";
    }
    //finally, return the CSS class name
    console.log("Converting. Received " + arrayName + " and returning " + answerStr);
    return answerStr;
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
                validArray.push(convertToCSSClass(window["SpeedArray" + temp]));
            }
        }
    }
    else if (selectedCard.type == "attack") {
        var temp = "";
        while(roll(temp) != "") {
            temp = roll(temp);            
            if (window["DriveArray" + temp][0] && window["DriveArray" + temp][window["DriveArray" + temp].length-1].type == "remedy") {
                validArray.push(convertToCSSClass(window["DriveArray" + temp]));
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

//TODO use this function
function highlightValidMoves() {
    //first, select the currently selected card
    //document.getElementById(selectedCard.id).classList.add("backlit");
    document.getElementById(selectedCard.id).classList.add("hoverSim");
    //Then highlight the possible options
    for (var i=0; i<validArray.length; i++) {
        document.getElementsByClassName(validArray[i])[0].classList.add("backlit");
    }
}

//TODO use this function
function unhighlightValidMoves() {
    if(document.getElementsByClassName("hoverSim")[0]) {
        document.getElementsByClassName("hoverSim")[0].classList.remove("hoverSim");
    }
    //Unhighlight the possible options
    for (var i=0; i<validArray.length; i++) {
        document.getElementsByClassName(validArray[i])[1].classList.remove("backlit");
    }
}

//TODO use this function
function prepUserTurn() {
    //highlight the draw pile
    document.getElementsByClassName("discardPile")[1].classList.add("backlit");
    document.getElementsByClassName("drawPile")[1].classList.add("backlit");
}

function clickDrawPile() {
    if (is_turn && !haveDrawn) {
        //draw a card
        document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
        document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = 7;
        document.getElementById(cardArray[cardArray.length-1].id).childNodes[1].classList.toggle("flip");
        document.getElementById(cardArray[cardArray.length-1].id).classList.add("playerHand7");
        HandArray.push(cardArray[cardArray.length-1]);
        cardArray.pop();
        haveDrawn = true;
        //document.getElementsByClassName("discardPile")[1].classList.remove("backlit");
        //document.getElementsByClassName("drawPile")[1].classList.remove("backlit");
        setTimeout(selectCard, 300, 7);
    }
}

//TODO finish and use this function
function clickDiscardPile() {
    //check for the scenario where the user is trying to draw from the DiscardPile
    if (isUserTurn && !haveDrawn && discardPileArray[0]) {
        //draw a card
        document.getElementById(discardPileArray[discardPileArray.length-1].id).classList.remove("discardPile");
        document.getElementById(discardPileArray[discardPileArray.length-1].id).style.zIndex = 7;
        document.getElementById(discardPileArray[discardPileArray.length-1].id).classList.add("UserCard7");
        UserHandArray.push(discardPileArray[discardPileArray.length-1]);
        discardPileArray.pop();
        haveDrawn = true;
        document.getElementsByClassName("discardPile")[1].classList.remove("backlit");
        document.getElementsByClassName("drawPile")[1].classList.remove("backlit");
        setTimeout(selectCard, 300, 7);
    }
    else if (isUserTurn && haveDrawn && selectedCard != null) {
        //The user is discarding
        playCard("User", UserHandArray.indexOf(selectedCard)+1, document.getElementById(selectedCard.id), selectedCard, "discardPile");
        //clear out and reset
        selectedCard = null;
        unhighlightValidMoves();
        haveDrawn = false;
        validArray = [];
        isUserTurn = false;
        if(cardArray.length == 0) {
            reshuffle();
        }
        setTimeout(takeTurnPC, 1000);
    }
}

//TODO finish and use this function
function clickOverlay(location) {
    if (validArray[0] && validArray.includes(location)) {
        //stop highlighting items
        unhighlightValidMoves();
        //move the card to take the turn
        playCard("User", UserHandArray.indexOf(selectedCard)+1, document.getElementById(selectedCard.id), selectedCard, location);
        //clear selectedCard
        selectedCard = null;
        //clear out validArray
        validArray = [];
        //clear haveDrawn
        haveDrawn = false;
        //stop the user's turn
        isUserTurn = false;
        if(cardArray.length == 0) {
            reshuffle();
        }
        //turn the turn over to the PC
        //setTimeout(takeTurnPC, 1000);
    }
}

//TODO finish and use this function
function playCard(who, cardNumInHand, cardElement, card, whereTo) {
    //remove the current class
    cardElement.classList.remove(who+"Card"+cardNumInHand);
    //arrange the new z-index and add the new class
    if(whereTo == "PCDrive") {
        if (!PCDriveArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = PCDriveArray.length + 1;
        PCDriveArray.push(card);
    }
    else if (whereTo == "PCSpeed") {
        if (!PCSpeedArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = PCSpeedArray.length + 1;
        PCSpeedArray.push(card);
    }
    else if (whereTo == "PCMiles") {
        if (!PCMilesArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = PCMilesArray.length + 1;
        PCMilesArray.push(card);
        updateScore("PC");
    }
    else if (whereTo == "UserDrive") {
        if (!UserDriveArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = UserDriveArray.length + 1;
        UserDriveArray.push(card);
    }
    else if (whereTo == "UserSpeed") {
        if (!UserSpeedArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = UserSpeedArray.length + 1;
        UserSpeedArray.push(card);
    }
    else if (whereTo == "UserMiles") {
        if (!UserMilesArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = UserMilesArray.length + 1;
        UserMilesArray.push(card);
        updateScore("User");
    }
    else if(whereTo == "discardPile") {
        if (!discardPileArray[0]) {
            cardElement.style.zIndex = 1;
        }
        else cardElement.style.zIndex = discardPileArray.length + 1;
        discardPileArray.push(card);
    }

    //add the new class
    cardElement.classList.add(whereTo);
    //flip the card if it's coming from the PC hand and remove the card from the hand array
    if (who == "PC") {
        cardElement.childNodes[1].classList.toggle("flip");
        PCHandArray.splice(cardNumInHand-1,1);
        //End the turn and shift the cards in hand left
        shiftCards("PC", cardNumInHand);
        isUserTurn = true;
        if(cardArray.length == 0) {
            reshuffle();
        }    
        //highlight the draw piles that are relevant
        setTimeout(prepUserTurn, 1000); 
    }
    else {
        UserHandArray.splice(cardNumInHand-1,1);
        //End the turn and shift the cards in hand left
        shiftCards("User", cardNumInHand);
        isUserTurn = false;
        if(cardArray.length == 0) {
            reshuffle();
        }
    }
}

//TODO finish and use this function
function shiftCards(who, cardNumInHand) {
    for (var i=cardNumInHand+1; i<=7; i++) {
        var cardElement = document.getElementsByClassName(who+"Card"+i)[0];
        cardElement.classList.remove(who+"Card"+i);
        var cardNumMinus1 = i-1;
        cardElement.classList.add(who+"Card"+cardNumMinus1);
        cardElement.style.zIndex = cardNumMinus1;
    }
}

//TODO finish and use this function
function updateScore(who) {
    var total = 0;
    if (who == "PC") {
        for (var i=0; i < PCMilesArray.length; i++) {
            total += Number(PCMilesArray[i].name);
        }
        document.getElementById("PCScore").innerHTML = "Score: " + total;
        if (!afterGame && total >= 1000) endGame("PC");
    }
    else if (who == "User") {
        for (var i=0; i < UserMilesArray.length; i++) {
            total += Number(UserMilesArray[i].name);
        }
        document.getElementById("UserScore").innerHTML = "Score: " + total;
        if (!afterGame && total >= 1000) endGame("User");
    }
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