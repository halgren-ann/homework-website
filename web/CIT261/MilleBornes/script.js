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
        console.log("PCCard" + i + ": " + cardArray[cardArray.length-1].name);
        document.getElementById(cardArray[cardArray.length-1].id).classList.remove("drawPile");
        document.getElementById(cardArray[cardArray.length-1].id).style.zIndex = i;
        document.getElementById(cardArray[cardArray.length-1].id).classList.add("PCCard" + i);
        PCHandArray.push(cardArray[cardArray.length-1]);
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
    takeTurnPC();
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
        console.log("Arrived inside the PCDriveArray == null");
        for (var i=1; i<=7; i++) {
            //look at each card in the PC hand
            var cardElement = document.getElementsByClassName("PCCard"+i)[0];
            var card = PCHandArray[i-1];
            //now I've found the card and can see what it is
            if (card.name == "Drive") {
                console.log("found the Drive card");
                //Play Drive Card
                cardElement.classList.remove("PCCard"+i);
                cardElement.style.zIndex = 1;
                cardElement.classList.add("PCDrive");
                cardElement.childNodes[1].classList.toggle("flip");
                PCDriveArray.push(card);
                PCHandArray.splice(i-1,1);
                isUserTurn = true;
                break;
            }
        }
    }

}

//Make the card object
//Valid values are as follows:
//name: 25, 50, 75, 100, 200, Drive, Stop, Gas, OutOfFuel, SpareTire, FlatTire, EndSpeedLimit, SpeedLimit, Repairs, Accident
//type: attack, remedy, mile
//location_class: relevant css classes (eg. UserCard1)
//availableToDraw: true, false
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