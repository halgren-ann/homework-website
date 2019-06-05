/*General Use AJAX*/
function AJAX(url_var, content_var) {
    var httpc = new XMLHttpRequest(); // simplified for clarity
    var url = url_var;
    httpc.open("POST", url, true); // sending as POST

    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    httpc.setRequestHeader("Content-Length", content_var.length); // POST request MUST have a Content-Length header (as per HTTP/1.1)

    httpc.onreadystatechange = function() { //Call a function when the state changes.
        if(httpc.readyState == 4 && httpc.status == 200) {
            return xmlhttp.responseText;
        }
        else {
            // What do when the request fails
            console.log('The request failed!');
        }
    }
    httpc.send(content_var);
}

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
var isUserTurn = false;
var haveDrawn = false;
var selectedCard = null;
var afterGame = false;
var validArray = new Array();

function makeGame() {
    //generate the random card stack
    cardArray = makeArray();
    cardArray = shuffleArray(cardArray);
    //populate the draw pile
    for (var i=0; i<cardArray.length; i++) {
        document.getElementById(cardArray[i].id).style = "z-index:" + (i+1);
    }
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

///////////////////////////////////////////END GAME PLANE///////////////////////////////







/////////////////////////////////////////START PLANE/////////////////////////////////////
/*
This function gathers the input keyword. If the keyword is found in the databse:
    - The player is assigned a number (2-4) and added to that game instance
If the keyword is not found in the database:
    - A new instance of the game is created and this player is made the game host
*/
function assessKeyword () {
    //TODO make sure the case where a keyword was not entered is accounted for
    var keyword = document.getElementById("keyword").textContent;
    console.log("Keyword was" + keyword);
    var response = AJAX("assessKeyword.php", keyword); 
    //the response will be a number 1-4 representing this player's player_number (0 means the player is the host).
    //If there were already 4 players when the request was made, the response will be "error"
    console.log("This player's number is " + response);

    //document.getElementById("startPage").classList.add("hidden");
    //send the keyword to the server
    //document.getElementById("gamePlane").classList.remove("hidden");
}

//TODO: create function playPCGame that begins a game between the user and the PC


//////////////////////////////////////END START PLANE///////////////////////////////////









//////////////////////////////////////////WAITING PLANE////////////////////////////////

////////////////////////////////////END WAITING PLANE//////////////////////////////////