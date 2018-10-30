function drawCheckeredBackground(can, nRow, nCol) {
    var ctx = can.getContext("2d");
    var w = can.width;
    var h = can.height;

    nRow = nRow || 8;    // default number of rows
    nCol = nCol || 8;    // default number of columns

    w /= nCol;            // width of a block
    h /= nRow;            // height of a block

    for (var i = 0; i < nRow; ++i) {
        for (var j = 0, col = nCol / 2; j < col; ++j) {
            ctx.rect(2 * j * w + (i % 2 ? 0 : w), i * h, w, h);
        }
    }
		ctx.fillStyle ="#D2691E";
    ctx.fill();
}

var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
ctx.fillStyle = "#FFFF00";
ctx.fillRect(0, 0, canvas.width, canvas.height);
drawCheckeredBackground(canvas, 4, 6);

//Create the food objects
function Coordinate(top, left) {
    this.top = top;
    this.left = left;
}

function Broccoli(top, left, name) {
    this.location = new Coordinate(top, left);
    this.isGood = true;
    this.audioFile = "blip";
    this.name = name;
}

function Bread(top,left, name) {
    this.location = new Coordinate(top, left);
    this.isGood = true;
    this.audioFile = "blip";
    this.name = name;
}

function Coffee(top, left, name) {
    this.location = new Coordinate(top, left);
    this.isGood = false;
    this.audioFile = "buzzer";
    this.name = name;
}

//Create the array of food objects
var foodArray = new Array();
foodArray.push(new Broccoli(8, 508, "broccoli1"));
foodArray.push(new Broccoli(108, 308, "broccoli2"));
foodArray.push(new Broccoli(208, 108, "broccoli3"));
foodArray.push(new Bread(8, 208, "bread1"));
foodArray.push(new Bread(208, 408, "bread2"));
foodArray.push(new Bread(308, 8, "bread3"));
foodArray.push(new Coffee(8, 108, "coffee1"));
foodArray.push(new Coffee(208, 508, "coffee2"));
foodArray.push(new Coffee(308, 208, "coffee3"));

//Moving the gamepiece and label
document.onkeydown = checkKey;

function checkKey(e) {

    e = e || window.event;
    currentTop = parseInt(document.getElementById("gamepiece").style.top, 10);
    currentLeft = parseInt(document.getElementById("gamepiece").style.left, 10);

    if (e.keyCode == '38') {
        // up arrow
        if (currentTop > 50) {
            document.getElementById("gamepiece").style.top = (currentTop - 100) + "px";
            document.getElementById("youAreHere").style.top = (currentTop - 82) + "px";            
        }
    }
    else if (e.keyCode == '40') {
        // down arrow
        if (currentTop < 250) {
            document.getElementById("gamepiece").style.top = (currentTop + 100) + "px";
            document.getElementById("youAreHere").style.top = (currentTop + 118) + "px";
        }
    }
    else if (e.keyCode == '37') {
        // left arrow
        if (currentLeft > 50) {
            document.getElementById("gamepiece").style.left = (currentLeft - 100) + "px";
            document.getElementById("youAreHere").style.left = currentLeft + "px";
        }
    }
    else if (e.keyCode == '39') {
        // right arrow
        if (currentLeft < 450) {
            document.getElementById("gamepiece").style.left = (currentLeft + 100) + "px";
            document.getElementById("youAreHere").style.left = (currentLeft + 200) + "px";
        }
    }

    checkLocation();
}

//See if you just ate a food
function checkLocation() {
    var gamepiece = document.getElementById("gamepiece");
    for (var i=0; i<foodArray.length; i++) {
        if (parseInt(gamepiece.style.top, 10) == foodArray[i].location.top) {
            if (parseInt(gamepiece.style.left, 10) == foodArray[i].location.left) {
                //You just ate something
                //Turn colors and scale
                if (foodArray[i].isGood) {
                    gamepiece.classList.add("changeGreen");
                    document.getElementById(foodArray[i].audioFile).play();
                    setTimeout(function(){ gamepiece.className = gamepiece.className.replace("changeGreen", ""); }, 1000);
                }
                else {
                    gamepiece.classList.add("changeRed");
                    document.getElementById(foodArray[i].audioFile).play();
                    setTimeout(function(){ gamepiece.className = gamepiece.className.replace("changeRed", ""); }, 1000);
                }
                //hide this image
                document.getElementById(foodArray[i].name).classList.add("hidden");
                //remove this food from the array
                foodArray.splice(i, 1);
                //break out of for loop, we found our food
                break;
            }
        }
    }
}

function on() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("instructionsVid").play();
}

function off() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("instructionsVid").pause();
}







