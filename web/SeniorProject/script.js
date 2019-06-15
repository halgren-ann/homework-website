//TODO protect all inputs against malicious entry with htmlspecialchars etc.

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

//Global variables for other player's information
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
//cardArray is the draw deck
var cardArray = new Array(); 
/*var PCHandArray = new Array();
var UserHandArray = new Array();
var PCDriveArray = new Array();
var UserDriveArray = new Array();
var PCSpeedArray = new Array();
var UserSpeedArray = new Array();
var PCMilesArray = new Array();
var UserMilesArray = new Array();*/
var discardPileArray = new Array();
//items relevant to game play logic
var haveDrawn = false;
var selectedCard = null;
var afterGame = false;
var validArray = new Array();

function startGame() {
    //generate the random card stack
    cardArray = makeArray();
    cardArray = shuffleArray(cardArray);
    //populate the draw pile
    for (var i=0; i<cardArray.length; i++) {
        document.getElementById(cardArray[i].id).style = "z-index:" + (i+1);
    }

    var JSONstr = '{"game_id": ' + game_id + ', "cardArray": ' + JSON.stringify(cardArray) + '}';

    //Send this deck information to the server
    AJAX("makeGame.php", JSONstr, null);
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