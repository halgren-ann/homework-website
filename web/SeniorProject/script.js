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
                console.log("Size of cards array on js side: " + updatesArray[i].cards.length);
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
        for (var j=0; j<num_players; j++) {
            var tempPlayerNum = roll(j); //Always deal to player number 1 first
            document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
            document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = i;
            if (tempPlayerNum == "") {
                //We're currently dealing to this user
                document.getElementById(cardArray[cardArray.length-1].id).childNodes[1].classList.toggle("flip");
                document.getElementById(cardArray[cardArray.length-1].id).classList.add("playerHand" + i);
                console.log("card added to css class " + "playerHand" + i);
            }
            else {
                document.getElementById(cardArray[cardArray.length-1].id).classList.add(convertToCSSClass("HandArray" + tempPlayerNum));
                console.log("card added to css class " + convertToCSSClass("HandArray" + tempPlayerNum));
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
    console.log("In roll. Received: " + num);
    //add one to the input
    if (num === 0) {
        num = 1;
    }
    else if (num === "") {
        num = player_number + 1;
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
        console.log("Returning from roll with: empty string");
        return "";
    }
    else {
        console.log("Returning from roll with: " + num);
        return num;
    }

}

/*This function takes the name of a card stack array and, based on the number of players, the current user's player number, and the input,
returns the name of the CSS class that the array is visually positioned with.*/
//TODO wherever this is returned, account for if the array is this user's hand, which applies to several CSS classes instead of just one
function convertToCSSClass(arrayName) {
    console.log("In convertToCSSClass function. arrayName: " + arrayName + " player_number: " + player_number);
    //the draw deck and discard pile are always in the same place, so the meaningful inputs are the DriveArray, SpeedArray, MilesArray, and HandArray variables
    var answerStr = "";
    //first, figure out the top, bottom, right, left player position on this user's screen
    var last = arrayName[arrayName.length-1];
    if (last == "y") {
        //this array belongs to the current player
        answerStr += "bottomLeftPlayer";
    }
    else {
        console.log("last: " + last);
        //find out how far offset the player is from this user
        var counter = 1;
        var rollOnThis = "";
        for (var i=0; i<num_players; i++) {
            console.log("Time number " + counter +  " through the loop. rollOnThis: " + rollOnThis + " roll(rollOnThis): " + roll(rollOnThis));
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

//Add a click event listener to handle the clickable areas
function handleClick(e) {    
    /*
    e.preventDefault();
    if (haveDrawn) {
        if(!e.target.parentElement || !e.target.parentElement.parentElement || !e.target.parentElement.parentElement.parentElement) return;
        if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard1")) selectCard(1);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard2")) selectCard(2);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard3")) selectCard(3);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard4")) selectCard(4);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard5")) selectCard(5);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard6")) selectCard(6);
        else if (e.target.parentElement.parentElement.parentElement.classList.contains("UserCard7")) selectCard(7);
    }
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