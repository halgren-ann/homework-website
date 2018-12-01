//cardArray is the draw deck
var cardArray = new Array(); 
//items relevant to game play logic
var PCHandArray = new Array();
var UserHandArray = new Array();
var PCDriveArray = new Array();
var UserDriveArray = new Array();
var PCSpeedArray = new Array();
var UserSpeedArray = new Array();
var PCMilesArray = new Array();
var UserMilesArray = new Array();
var discardPileArray = new Array();
var isUserTurn = false;

function makeGame() {
    //generate the random card stack
    cardArray = makeArray();
    cardArray = shuffleArray(cardArray);
    //populate the draw pile
    for (var i=0; i<cardArray.length; i++) {
        document.getElementById(cardArray[i].id).style = "z-index:" + i;
    }
    //populate the PC's hand
    for (var i=1; i<=6; i++) {
        document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
        document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = i;
        document.getElementById(cardArray[cardArray.length-1].id).classList.add("PCCard" + i);
        PCHandArray.push(cardArray[cardArray.length-1]);
        console.log("PCCard"+i+": "+ cardArray[cardArray.length-1].name);
        cardArray.pop();
    }
    //populate the User's hand
    for (var i=1; i<=6; i++) {
        document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
        document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = i;
        document.getElementById(cardArray[cardArray.length-1].id).childNodes[1].classList.toggle("flip");
        document.getElementById(cardArray[cardArray.length-1].id).classList.add("UserCard" + i);
        UserHandArray.push(cardArray[cardArray.length-1]);
        cardArray.pop();
    }

    //for testing purposes, have the computer take a turn
    setTimeout(takeTurnPC, 1500);
}

function newGame() {
    location.reload();
}

function getInstructions() {

}

function takeTurnPC() {
    //draw from drawPile
    document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
    document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = 7;
    document.getElementById(cardArray[cardArray.length-1].id).classList.add("PCCard7");
    PCHandArray.push(cardArray[cardArray.length-1]);
    cardArray.pop();
    //if no drive yet, play drive card if can
    if (!PCDriveArray[0]) {
        for (var i=1; i<=7; i++) {
            //look at each card in the PC hand
            var cardElement = document.getElementsByClassName("PCCard"+i)[0];
            var card = PCHandArray[i-1];
            if (card.name == "Drive") {
                playCard("PC", i, cardElement, card, "PCDrive");
                return;
            }
        }
    }
    //if can attack the other player, do so
    //first, check the drive pile (a drive must have been played first)
    if (UserDriveArray[0] && UserDriveArray[UserDriveArray.length-1].type == "remedy") {
        //See if I have any attack cards for the drive pile
        for (var i=1; i<=7; i++) {
            //look at each card in the PC hand
            var cardElement = document.getElementsByClassName("PCCard"+i)[0];
            var card = PCHandArray[i-1];
            if (card.type == "attack" && card.name != "SpeedLimit") {
                playCard("PC", i, cardElement, card, "UserDrive");
                return;
            }
        }
    }
    //now check the speed limit pile
    if (!UserSpeedArray[0] || UserSpeedArray[UserSpeedArray-1].type == "remedy") {
        //See if I have any attack cards for the speed pile
        for (var i=1; i<=7; i++) {
            //look at each card in the PC hand
            var cardElement = document.getElementsByClassName("PCCard"+i)[0];
            var card = PCHandArray[i-1];
            if (card.name == "SpeedLimit") {
                playCard("PC", i, cardElement, card, "UserSpeed");
                return;
            }
        }
    }
    //if can remedy self, remedy
    //check the drive pile for current attacks
    if (PCDriveArray[0] && PCDriveArray[PCDriveArray-1].type == "attack") {
        //Find out what the attack card is and then check my hand for the remedy
        if (PCDriveArray[PCDriveArray-1].name == "Stop") {
            for (var i=1; i<=7; i++) {
                //look at each card in the PC hand
                var cardElement = document.getElementsByClassName("PCCard"+i)[0];
                var card = PCHandArray[i-1];
                if (card.name == "Drive") {
                    playCard("PC", i, cardElement, card, "PCDrive");
                    return;
                }
            }
        }
        else if (PCDriveArray[PCDriveArray-1].name == "OutOfFuel") {
            for (var i=1; i<=7; i++) {
                //look at each card in the PC hand
                var cardElement = document.getElementsByClassName("PCCard"+i)[0];
                var card = PCHandArray[i-1];
                if (card.name == "Gas") {
                    playCard("PC", i, cardElement, card, "PCDrive");
                    return;
                }
            }
        }
        else if (PCDriveArray[PCDriveArray-1].name == "FlatTire") {
            for (var i=1; i<=7; i++) {
                //look at each card in the PC hand
                var cardElement = document.getElementsByClassName("PCCard"+i)[0];
                var card = PCHandArray[i-1];
                if (card.name == "SpareTire") {
                    playCard("PC", i, cardElement, card, "PCDrive");
                    return;
                }
            }
        }
        else if (PCDriveArray[PCDriveArray-1].name == "Accident") {
            for (var i=1; i<=7; i++) {
                //look at each card in the PC hand
                var cardElement = document.getElementsByClassName("PCCard"+i)[0];
                var card = PCHandArray[i-1];
                if (card.name == "Repairs") {
                    playCard("PC", i, cardElement, card, "PCDrive");
                    return;
                }
            }
        }
    }
    //check the speed pile for a current attack
    if (PCSpeedArray[0] && PCSpeedArray[PCSpeedArray-1].type == "attack") {
        //See if I have any remedy cards for the speed pile
        for (var i=1; i<=7; i++) {
            //look at each card in the PC hand
            var cardElement = document.getElementsByClassName("PCCard"+i)[0];
            var card = PCHandArray[i-1];
            if (card.name == "EndSpeedLimit") {
                playCard("PC", i, cardElement, card, "PCSpeed");
                return;
            }
        }
    }
    //if I have a mile card, play my highest mile card
    //can only do this if I have a drive card down
    //can only do this if my drive pile is not attacked
    //can only go up to 50 if I have a speed limit on me
    if (PCDriveArray[0] && PCDriveArray[PCDriveArray.length-1].type != "attack") {
        var highest = 0;
        var location = -1;
        for (var i=1; i<=7; i++) {
            //look at each card in the PC hand
            var cardElement = document.getElementsByClassName("PCCard"+i)[0];
            var card = PCHandArray[i-1];
            if (card.type == "mile") {
                //check if I have a speed limit on me
                if (PCSpeedArray[0] && PCSpeedArray[PCSpeedArray.length-1].type == "attack") {
                    //can go a maximum of 50
                    if (Number(card.name) > highest && Number(card.name) <= 50) {
                        //this card is the new highest
                        highest = Number(card.name);
                        location = i;
                    }
                }
                else if (Number(card.name) > highest) {
                    //this card is the new highest
                    highest = Number(card.name);
                    location = i;
                }
            }
        }
        //if I found the highest mile card, play it
        if (highest > 0) {
            playCard("PC", location, document.getElementsByClassName("PCCard"+location)[0], PCHandArray[location-1], "PCMiles");
            return;
        }
    }

    //If I still haven't done anything, I need to discard a card
    //discarding will happen randomly
    //generate a random number between 1 and 7, inclusive
    var x = Math.floor((Math.random() * 7) + 1);
    playCard("Pc", x, document.getElementsByClassName("PCCard"+x)[0], PCHandArray[x-1], "discardPile");
}

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
    }
    else {
        UserHandArray.splice(cardNumInHand-1,1);
        //End the turn and shift the cards in hand left
        shiftCards("User", cardNumInHand);
        isUserTurn = false;
    }
}

function shiftCards(who, cardNum) {
    for (var i=cardNum+1; i<=7; i++) {
        var cardElement = document.getElementsByClassName(who+"Card"+i)[0];
        cardElement.classList.remove(who+"Card"+i);
        cardElement.classList.add(who+"Card"+(i-1));
        cardElement.zIndex = i-1;
    }
}

function updateScore(who) {
    var total = 0;
    if (who == "PC") {
        for (var i=0; i < PCMilesArray.length; i++) {
            total += Number(PCMilesArray[i].name);
        }
        document.getElementById("PCScore").innerHTML = "Score: " + total;
    }
    else if (who == "User") {
        for (var i=0; i < UserMilesArray.length; i++) {
            total += Number(UserMilesArray[i].name);
        }
        document.getElementById("UserScore").innerHTML = "Score: " + total;
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