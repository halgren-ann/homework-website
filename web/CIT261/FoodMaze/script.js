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
            document.getElementById("youAreHere").style.top = (currentTop - 100) + "px";
            gamepiece.classList.add("changeRed");
            setTimeout(function(){ gamepiece.className = gamepiece.className.replace("changeRed", ""); }, 3000);            
        }
    }
    else if (e.keyCode == '40') {
        // down arrow
        if (currentTop < 250) {
            document.getElementById("gamepiece").style.top = (currentTop + 100) + "px";
            document.getElementById("youAreHere").style.top = (currentTop + 100) + "px";
            gamepiece.classList.add("changeGreen");
            setTimeout(function(){ gamepiece.className = gamepiece.className.replace("changeGreen", ""); }, 3000);
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
}

/*
var gamepiece = document.getElementById("gamepiece");


gamepiece.classList.add("changeGreen");
setTimeout(function(){ gamepiece.className = gamepiece.className.replace("changeGreen", ""); }, 3000);


gamepiece.classList.add("changeRed");
setTimeout(function(){ gamepiece.className = gamepiece.className.replace("changeRed", ""); }, 3000);
*/







